sap.ui.define([
    "sap/ui/core/mvc/Controller",
    "sap/ui/model/json/JSONModel",
    "sap/m/MessageToast"
], function (Controller, JSONModel, MessageToast) {
    "use strict";

    return Controller.extend("ui5.walkthrough.controller.App", {
        onInit: function () {
            let userModel = this.getOwnerComponent().getModel("user");

            let username = userModel.getProperty("/data/username");
            let id = userModel.getProperty("/data/id");

            let oUserModel = new JSONModel({
                userName: username,
                userId: id,
            });

            this.getView().setModel(oUserModel, "userModel");

            this.loadInvoices();
        },

        loadInvoices: function () {
            let oModel = this.getView().getModel("userModel");
            let userId = oModel.getProperty("/userId");


            fetch(`http://localhost:8000/public/index.php/api/invoices/${userId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {

                        let invoiceModel = new JSONModel({

                            invoices: data.invoices
                        }
                        );
                        this.getView().setModel(invoiceModel, "invoice");

                    }
                })
                .catch(error => console.error("Erro ao carregar faturas:", error));
        },

        onAddInvoice: function () {
            let oView = this.getView();
            let oModel = oView.getModel("userModel");
            let userId = oModel.getProperty("/userId");

            let amount = oView.byId("inputAmount").getValue();
            let description = oView.byId("inputDescription").getValue();

            if (!amount || !description) {
                MessageToast.show("Preencha todos os campos!");
                return;
            }

            fetch("http://localhost:8000/public/index.php/api/invoices", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({
                    user_id: userId,
                    amount: parseFloat(amount),
                    description: description
                })
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        MessageToast.show("Fatura adicionada com sucesso!");
                        this.loadInvoices();
                    } else {
                        MessageToast.show("Erro ao adicionar fatura.");
                    }
                })
                .catch(error => console.error("Erro:", error));
        },

        onRemoveInvoice: function (oEvent) {
            let oModel = this.getView().getModel("userModel");
            let userId = oModel.getProperty("/userId");
            // Get the binding context for the clicked row
            var oContext = oEvent.getSource().getBindingContext("invoice");

            // Access the ID of the invoice
            var sInvoiceId = oContext.getProperty("id");

            // Log the ID or do something with it (e.g., call an API to remove the invoice)
            console.log("Invoice ID to remove:", sInvoiceId)


            fetch("http://localhost:8000/public/index.php/api/invoices", {
                method: "DELETE",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({
                    user_id: userId,
                    invoice_id: sInvoiceId
                })
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        MessageToast.show("Fatura removida!");
                        this.loadInvoices();
                    } else {
                        MessageToast.show("Erro ao remover fatura.");
                    }
                })
                .catch(error => console.error("Erro:", error));
        }
    });
});
