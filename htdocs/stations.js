/* This script and many more are available free online at
The JavaScript Source :: http://javascript.internet.com
Created by: Down Home Consulting :: http://downhomeconsulting.com */

/*
Country State Drop Downs v1.0.
(c) Copyright 2005 Down Home Consulting, Inc.
www.DownHomeConsulting.com

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without 
restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the 
Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software. The software is provided "as is", without warranty of any 
kind, express or implied, including but not limited to the warranties of merchantability, itness for a particular purpose and noninfringement. in no event shall the authors or copyright 
holders be liable for any claim, damages or other liability, whether in an action of contract, tort or otherwise, arising from, out of or in connection with the software or the use or other 
dealings in the software.

*/

// If you have PHP you can set the post values like this
//var postState = '<?= $_POST["state"] ?>';
//var postCountry = '<?= $_POST["country"] ?>';
var postStation = '';
var postState = '';

// State table
//
// To edit the list, just delete a line or add a line. Order is important.
// The order displayed here is the order it appears on the drop down.
//
var station = 'IA:kdsm:Des Moines|IA:kmcw:Mason City|IA:p#a:Slater|';

// States data table
//
// To edit the list, just delete a line or add a line. Order is important.
// The order displayed here is the order it appears on the drop down.
//
var state = '\
AK:Alaska|\
AL:Alabama|\
AR:Arkansas|\
AS:American Samoa|\
AZ:Arizona|\
CA:California|\
CO:Colorado|\
CT:Connecticut|\
DC:D.C.|\
DE:Delaware|\
FL:Florida|\
FM:Micronesia|\
GA:Georgia|\
GU:Guam|\
HI:Hawaii|\
IA:Iowa|\
ID:Idaho|\
IL:Illinois|\
IN:Indiana|\
KS:Kansas|\
KY:Kentucky|\
LA:Louisiana|\
MA:Massachusetts|\
MD:Maryland|\
ME:Maine|\
MH:Marshall Islands|\
MI:Michigan|\
MN:Minnesota|\
MO:Missouri|\
MP:Marianas|\
MS:Mississippi|\
MT:Montana|\
NC:North Carolina|\
ND:North Dakota|\
NE:Nebraska|\
NH:New Hampshire|\
NJ:New Jersey|\
NM:New Mexico|\
NV:Nevada|\
NY:New York|\
OH:Ohio|\
OK:Oklahoma|\
OR:Oregon|\
PA:Pennsylvania|\
PR:Puerto Rico|\
PW:Palau|\
RI:Rhode Island|\
SC:South Carolina|\
SD:South Dakota|\
TN:Tennessee|\
TX:Texas|\
UT:Utah|\
VA:Virginia|\
VI:Virgin Islands|\
VT:Vermont|\
WA:Washington|\
WI:Wisconsin|\
WV:West Virginia|\
WY:Wyoming|\
AA:Military Americas|\
AE:Military Europe/ME/Canada|\
AP:Military Pacific|\
';

function TrimString(sInString) {
  if ( sInString ) {
    sInString = sInString.replace( /^\s+/g, "" );// strip leading
    return sInString.replace( /\s+$/g, "" );// strip trailing
  }
}

// Populates the country selected with the counties from the country list
function populateState(defaultState) {
  if ( postState != '' ) {
    defaultState = postState;
  }
  var stateLineArray = state.split('|');  // Split into lines
  var selObj = document.getElementById('stateSelect');
  selObj.options[0] = new Option('Select State','');
  selObj.selectedIndex = 0;
  for (var loop = 0; loop < stateLineArray.length; loop++) {
    lineArray = stateLineArray[loop].split(':');
    stateCode  = TrimString(lineArray[0]);
    stateName  = TrimString(lineArray[1]);
    if ( stateCode != '' ) {
      selObj.options[loop + 1] = new Option(stateName, stateCode);
    }
    if ( defaultState == stateCode ) {
      selObj.selectedIndex = loop + 1;
    }
  }
}

function populateStation() {
  var selObj = document.getElementById('stationSelect');
  var foundStation = false;
  // Empty options just in case new drop down is shorter
  if ( selObj.type == 'select-one' ) {
    for (var i = 0; i < selObj.options.length; i++) {
      selObj.options[i] = null;
    }
    selObj.options.length=null;
    selObj.options[0] = new Option('Select Station','');
    selObj.selectedIndex = 0;
  }
  // Populate the drop down with states from the selected State
  var stationLineArray = state.split("|");  // Split into lines
  var optionCntr = 1;
  for (var loop = 0; loop < stationLineArray.length; loop++) {
    lineArray = stationLineArray[loop].split(":");
    countryCode  = TrimString(lineArray[0]);
    stationCode    = TrimString(lineArray[1]);
    stationName    = TrimString(lineArray[2]);
  if (document.getElementById('stateSelect').value == stateCode && stateCode != '' ) {
    // If it's a input element, change it to a select
      if ( selObj.type == 'text' ) {
        parentObj = document.getElementById('stationSelect').parentNode;
        parentObj.removeChild(selObj);
        var inputSel = document.createElement("SELECT");
        inputSel.setAttribute("name","station");
        inputSel.setAttribute("id","stationSelect");
        parentObj.appendChild(inputSel) ;
        selObj = document.getElementById('stationSelect');
        selObj.options[0] = new Option('Select Station','');
        selObj.selectedIndex = 0;
      }
      if ( stateCode != '' ) {
        selObj.options[optionCntr] = new Option(stationName, stationCode);
      }
      // See if it's selected from a previous post
      if ( stationCode == postStation && stateCode == postState ) {
        selObj.selectedIndex = optionCntr;
      }
      foundState = true;
      optionCntr++
    }
  }
  // If the country has no states, change the select to a text box
  if ( ! foundStation ) {
    parentObj = document.getElementById('stationSelect').parentNode;
    parentObj.removeChild(selObj);
  // Create the Input Field
    var inputEl = document.createElement("INPUT");
    inputEl.setAttribute("id", "stationSelect");
    inputEl.setAttribute("type", "text");
    inputEl.setAttribute("name", "station");
    inputEl.setAttribute("size", 20);
    inputEl.setAttribute("value", postStation);
    parentObj.appendChild(inputEl) ;
  }
}

function initState(state) {
  populateState(state);
  populateStation();
}


