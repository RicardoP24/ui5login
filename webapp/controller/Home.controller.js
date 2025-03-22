sap.ui.define([
    "sap/ui/core/mvc/Controller"
], function (Controller) {
    "use strict";

    return Controller.extend("ui5.walkthrough.controller.Home", {
        onLogout: function () {
            var oRouter = this.getOwnerComponent().getRouter();
            oRouter.navTo("login"); // Retorna para a tela de login
        }
    });
});
