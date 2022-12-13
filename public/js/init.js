import { ComponentsManager } from './libs/components_manager.js';
import { Query }             from './libs/query.js';
import { Basket }            from './libs/basket.js';
import { Messages }          from './libs/messages.js';

window.componentsManager = ComponentsManager;
window.query = new Query();
window.basket = new Basket();
window.messages = new Messages();

// window.getCookie = function (name) {
//   var match = document.cookie.match(new RegExp("(^| )" + name + "=([^;]+)"));
//   if (match) return match[2];
// };