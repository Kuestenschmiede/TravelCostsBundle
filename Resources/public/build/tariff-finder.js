!function(e){var t={};function i(r){if(t[r])return t[r].exports;var n=t[r]={i:r,l:!1,exports:{}};return e[r].call(n.exports,n,n.exports,i),n.l=!0,n.exports}i.m=e,i.c=t,i.d=function(e,t,r){i.o(e,t)||Object.defineProperty(e,t,{enumerable:!0,get:r})},i.r=function(e){"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(e,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(e,"__esModule",{value:!0})},i.t=function(e,t){if(1&t&&(e=i(e)),8&t)return e;if(4&t&&"object"==typeof e&&e&&e.__esModule)return e;var r=Object.create(null);if(i.r(r),Object.defineProperty(r,"default",{enumerable:!0,value:e}),2&t&&"string"!=typeof e)for(var n in e)i.d(r,n,function(t){return e[t]}.bind(null,n));return r},i.n=function(e){var t=e&&e.__esModule?function(){return e.default}:function(){return e};return i.d(t,"a",t),t},i.o=function(e,t){return Object.prototype.hasOwnProperty.call(e,t)},i.p="",i(i.s=3)}([function(e,t,i){"use strict";i.d(t,"a",function(){return r});
/*
 * This file is part of con4gis,
 * the gis-kit for Contao CMS.
 *
 * @package    con4gis
 * @version    6
 * @author     con4gis contributors (see "authors.txt")
 * @license    LGPL-3.0-or-later
 * @copyright  Küstenschmiede GmbH Software & Design
 * @link       https://www.con4gis.org
 */
var r={DUMMY_INPUT:"Street, city or enter postal code ...",HEADLINE_DIST:"Distance",HEADLINE_TIME:"Time",HEADLINE_BASE_PRICE:"Base price",HEADLINE_DIST_PRICE:"Price / km",HEADLINE_TIME_PRICE:"Price / min",ERROR_OUT_OF_BOUNDS:"Address is out of bounds",ERROR_FALSE_ADDRESS:"Address not found",ERROR:"Error",START_SEARCH:"Calculate",POSITION_OUT_OF_BOUNDS:"Your current position is out of bounds",NONE:""}},function(e,t,i){"use strict";i.d(t,"a",function(){return r});
/*
 * This file is part of con4gis,
 * the gis-kit for Contao CMS.
 *
 * @package    con4gis
 * @version    6
 * @author     con4gis contributors (see "authors.txt")
 * @license    LGPL-3.0-or-later
 * @copyright  Küstenschmiede GmbH Software & Design
 * @link       https://www.con4gis.org
 */
var r={DUMMY_INPUT:"Straße, Ort oder PLZ eingeben ...",HEADLINE_DIST:"Entfernung",HEADLINE_TIME:"Dauer",HEADLINE_BASE_PRICE:"Grundpreis",HEADLINE_DIST_PRICE:"Preis / km",HEADLINE_TIME_PRICE:"Preis / min",ERROR_OUT_OF_BOUNDS:"Adresse außerhalb des Tarifgebiets",ERROR_FALSE_ADDRESS:"Adresse nicht gefunden",ERROR:"Fehler",START_SEARCH:"Berechnen",POSITION_OUT_OF_BOUNDS:"Ihre aktuelle Position ist außerhalb des Tarifsgebiets",NONE:""}},,function(e,t,i){"use strict";i.r(t);var r=i(0),n=i(1);const d={};$(document).ready(function(){let e=window.serviceLang||window.navigator.userLanguage||window.navigator.language;"en"===e?$.extend(d,r.a):"de"===e?$.extend(d,n.a):$.extend(d,r.a),function(){let e="con4gis/tariffService/"+window.settingId;$.ajax({url:e}).done(function(e){let t=$(".tariff-output");"1"===window.displayGrid?t.css("display","grid"):t.css("display","block");let i="row-even",r=$(".headline-dist-price");r.html(d.HEADLINE_DIST_PRICE);let n=$(".headline-time-price");n.html(d.HEADLINE_TIME_PRICE);let a=$(".headline-base-price");a.html(d.HEADLINE_BASE_PRICE);for(let r in e)if(e.hasOwnProperty(r))if("1"===window.displayGrid){let n=document.createElement("div");n.innerHTML=r,n.className="grid-item "+i,t.append(n);let a=document.createElement("div");if(e[r].basePrice%1!=0){let t,i=e[r].basePrice+"0000";"de"===window.serviceLang?(i=i.replace(".",","),t=i.indexOf(",")+3):t=i.indexOf(".")+3,a.innerHTML=i.substring(0,t)+" €"}else a.innerHTML=e[r].basePrice+"€";a.className="grid-item "+i,t.append(a);let s="auto auto";if(e[r].distPrice.length>1){for(let n in e[r].distPrice)if(e[r].distPrice.hasOwnProperty(n)){let a=e[r].distPrice[n],o=d.HEADLINE_DIST_PRICE+"<br>"+a.name;if("0"===n){let e=$(".headline-dist-price");e.html(o)}else{let e=$(".headline-dist-price").last(),t=document.createElement("div");t.className="headline-dist-price grid-item",t.innerHTML=o,e.after(t)}let c=document.createElement("div");if(a.kilometerPrice%1!=0){let e,t=a.kilometerPrice+"0000";"de"===window.serviceLang?(t=t.replace(".",","),e=t.indexOf(",")+3):e=t.indexOf(".")+3,c.innerHTML=t.substring(0,e)+" €"}else c.innerHTML=a.kilometerPrice+"€";c.className="grid-item "+i,t.append(c),s+=" auto"}}else{let n=document.createElement("div"),d=e[r].distPrice[0].kilometerPrice+"0000",a=(d=d.replace(".",",")).indexOf(",")+3;n.innerHTML=d.substring(0,a)+" €",n.className="grid-item "+i,t.append(n)}if(0!=e[r].timePrice){let n=document.createElement("div");if(e[r].timePrice%1!=0){let t,i=e[r].timePrice+"0000";"de"===window.serviceLang?(i=i.replace(".",","),t=i.indexOf(",")+3):t=i.indexOf(".")+3,n.innerHTML=i.substring(0,t)+" €"}else n.innerHTML=e[r].timePrice+"€";n.className="grid-item "+i,t.append(n),i="row-even"===i?"row-uneven":"row-even",s+=" auto"}else $("*").remove(".headline-time-price");$(".tariff-output").css("grid-template-columns",s)}else{let i=document.createElement("tr");i.innerHTML="<th>"+r+"</th><td>"+e[r].basePrice+"€</td><td>"+e[r].distPrice+"€</td><td>"+e[r].timePrice+"€</td>",t.append(i)}})}()})}]);