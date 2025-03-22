sap.ui.define([
   "sap/ui/core/mvc/Controller",
   "sap/m/MessageToast"
], function (Controller, MessageToast) {
   "use strict";

   return Controller.extend("ui5.walkthrough.controller.Login", {
    onLogin: function () {
        var oRouter = this.getOwnerComponent().getRouter();
        var user = this.getView().byId("inputUser").getValue();
        var pass = this.getView().byId("inputPassword").getValue();

        if (!user || !pass) {
            MessageToast.show("Preencha todos os campos!");
            return;
        }

        fetch("http://localhost:8080/login.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify({ username: user, password: pass })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                MessageToast.show("Login bem-sucedido!");
                oRouter.navTo("home"); // Navega para a tela Home


            } else {
                MessageToast.show(data.message);
            }
        })
        .catch(error => {
            MessageToast.show(error);
            console.error(error);
        });
    }
   });
});
