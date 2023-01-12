var isNS4, isIE4, isIE5, isNS6, isIE8
var coll = ""
var styleObj = ""

var zIndex = 1  // Must be larger than our backgrounds

isNS4 = (document.layers) ? true : false;
isIE4 = (document.all && !document.getElementById) ? true : false;
isIE5 = (document.all && document.getElementById) ? true : false;
isNS6 = (!document.all && document.getElementById) ? true : false;
isIE8 = (document.all && document.getElementById) ? true : false;
if (isNS6 || isIE8) {
  coll = "getElementById('"
  styleObj = "').style" }
else {
  if (isIE4 || isIE5) {
    coll = "all."
    styleObj = ".style" } }

function changeVisibility(Obj,num) {
   var imgobj = eval("document." + coll + "image" + num + styleObj)

  if (Obj.checked) {
       imgobj.visibility = "visible"
// increase zIndex by 1
       zIndex++
       setZIndex(imgobj, zIndex)
   } else {
       imgobj.visibility = "hidden"
//     zIndex--
// if for some reason we wanted to subtract the zIndex value but no need 
// since this image is now hidden.
   }
}

function setZIndex(obj, zOrder) {
   obj.zIndex = zOrder
}

function openWin(url, name) {
                      popupWin = window.open(url, name,
                     'toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=1,resizable=1,width=350,height=120');

                      }

function openBWin(url) {
                      popupWin = window.open(url) 
;

                      }

