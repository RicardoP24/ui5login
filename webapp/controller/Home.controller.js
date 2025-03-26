sap.ui.define([
    "sap/ui/core/mvc/Controller",
    "sap/ui/model/json/JSONModel"
], function (Controller,JSONModel) {
    "use strict";

    return Controller.extend("ui5.walkthrough.controller.Home", {

        onInit: function (){
            let userModel=this.getOwnerComponent().getModel("user");

            let username = userModel.getProperty("/data/username");
            let id = userModel.getProperty("/data/id");

            let oViewModel = new JSONModel({
                userName: username,
                userId: id,
            });

            this.getView().setModel(oViewModel, "viewModel");

        },
        onLogout: function () {
            var oRouter = this.getOwnerComponent().getRouter();

            oRouter.navTo("login"); // Retorna para a tela de login
        }
    });
});
