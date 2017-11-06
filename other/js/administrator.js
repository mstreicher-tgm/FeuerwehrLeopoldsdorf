$(document).ready(function () {
  $('.dropdown-button').dropdown();
  $(".button-collapse").sideNav();
  $('select').material_select();
  $('.modal').modal();

  $('input#dienstgrad.autocomplete').autocomplete({
    data: {
      "Probefeuerwehrmann": '../../other/images/dienstgrade/PFM.png',
      "Feuerwehrmann": '../../other/images/dienstgrade/FM.png',
      "Oberfeuerwehrmann": '../../other/images/dienstgrade/OFM.png',
      "Hauptfeuerwehrmann": '../../other/images/dienstgrade/HFM.png',
      "Löschmeister": '../../other/images/dienstgrade/LM.png',
      "Oberlöschmeister": '../../other/images/dienstgrade/OLM.png',
      "Hauptlöschmeister": '../../other/images/dienstgrade/HLM.png',
      "Brandmeister": '../../other/images/dienstgrade/BM.png',
      "Oberbrandmeister": '../../other/images/dienstgrade/OBM.png',
      "Hauptbrandmeister": '../../other/images/dienstgrade/HBM.png',
      "Brandinspektor": '../../other/images/dienstgrade/BI.png',
      "Oberbrandinspektor": '../../other/images/dienstgrade/OBI.png',
      "Hauptbrandinspektor": '../../other/images/dienstgrade/HBI.png',
      "Abschnittsbrandinspektor": '../../other/images/dienstgrade/OBI.png',
      "Brandrat": '../../other/images/dienstgrade/BR.png',
      "Oberbrandrat": '../../other/images/dienstgrade/OBR.png',
      "Landesfeuerwehrrat": '../../other/images/dienstgrade/LFR.png',
      "Verwaltungsmeister": '../../other/images/dienstgrade/VM.png',
      "Oberverwaltungsmeister": '../../other/images/dienstgrade/OVM.png',
      "Hauptverwaltungsmeister": '../../other/images/dienstgrade/HVM.png',
      "Verwalter": '../../other/images/dienstgrade/V.png',
      "Oberverwalter": '../../other/images/dienstgrade/OV.png',
      "Hauptverwalter": '../../other/images/dienstgrade/HV.png',
      "Verwaltungsinspektor": '../../other/images/dienstgrade/VI.png',
      "Verwaltungsrat": '../../other/images/dienstgrade/VR.png',
      "Sachbearbeiter": '../../other/images/dienstgrade/SB.png',
      "Abschnittssachbearbeiter": '../../other/images/dienstgrade/ASB.png',
      "Bezirkssachbearbeiter": '../../other/images/dienstgrade/BSB.png'
    },
    onAutocomplete: function(val) {
    },
    minLength: 1,
  });
  $('input#berechtigung.autocomplete').autocomplete({
    data: {
      "Unberechtigter": null,
      "Chargen": null,
      "Administrator": null,
    },
    onAutocomplete: function(val) {
    },
    minLength: 1,
  });
});
