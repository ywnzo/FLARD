import { FETCH, GET_COOKIE} from "./utils.js";

var isSelecting = false;

function assign_events() {
  $(".list-wrapper").css("border", "2px solid var(--wrapper-active)");
  var links = document.querySelectorAll(".link");
  links.forEach((link) => {
    link.style.pointerEvents = "none";
    var wrapper = link.parentElement;
    wrapper.classList.add("wiggle");
    if (wrapper.classList.contains("link-wrapper-own")) {
      wrapper.addEventListener("click", delete_link, false);
    } else {
      wrapper.addEventListener("click", remove_from_account, false);
    }
    wrapper.link = link;
  });

  document.querySelector("#del-multi-btn").classList.remove("btn-main");
  document.querySelector("#del-multi-btn").classList.add("btn-main-invert");
}

function deassign_events() {
  $(".list-wrapper").css("border", "2px solid var(--wrapper-inactive)");
  var links = document.querySelectorAll(".link");
  links.forEach((link) => {
    link.style.pointerEvents = "auto";
    var wrapper = link.parentElement;
    wrapper.classList.remove("wiggle");
    if (wrapper.classList.contains("link-wrapper-own")) {
      wrapper.removeEventListener("click", delete_link, false);
    } else {
      wrapper.removeEventListener("click", remove_from_account, false);
    }
  });

  document.querySelector("#del-multi-btn").classList.remove("btn-main-invert");
  document.querySelector("#del-multi-btn").classList.add("btn-main");
}

function delete_link(e) {
  var link = e.currentTarget.link;
  var url = link.href;
  var urlObj = new URL(url);
  var params = new URLSearchParams(urlObj.search);
  var setID = params.get("set");
  var cardID = params.get("card");
  var userID = GET_COOKIE("userID");

  var table = window.location.href.includes("cards") ? "cards" : "cardSets";
  if (table === "cards") {
    var params = "ID = '" + cardID + "' AND setID = '" + setID + "' AND userID = '" + userID + "'";
  } else {
    var params = "ID = '" + setID + "' AND userID = '" + userID + "'";
  }

  var formData = new FormData();
  formData.append("method", "delete");
  formData.append("table", table);
  formData.append("params", params);
  FETCH("components/crud.php", formData, () => {});

  if(table === "cardSets") {
    var formData = new FormData();
    formData.append("method", "delete");
    formData.append("table", 'cards');
    formData.append("params", "setID = '" + setID + "'");
    FETCH("components/crud.php", formData, () => {});
  }

  link.parentElement.remove();

  var links = document.querySelectorAll(".link");
  if (links.length === 0) {
    deassign_events();
    $("#start-flashing-btn").remove();
  }
}

function remove_from_account(e) {
  var link = e.currentTarget.link;
  var url = link.href;
  var urlObj = new URL(url);
  var params = new URLSearchParams(urlObj.search);
  var setID = params.get("set");
  var userID = GET_COOKIE('userID');
  var params = "setID = '" + setID + "' AND userID = '" + userID + "'";
  alert(params)
  var formData = new FormData();
  formData.append("method", "delete");
  formData.append("table", "savedCardSets");
  formData.append("params", params);
  FETCH("components/crud.php", formData, () => {});
  link.parentElement.remove();

  var links = document.querySelectorAll(".link");
  if (links.length === 0) {
    deassign_events();
  }
}

function activate_selecting() {
  isSelecting = true;
  assign_events();
}

function deactivate_selecting() {
  isSelecting = false;
  deassign_events();
}

function main() {
  $("#del-multi-btn").on("click", function () {
    if (!isSelecting) {
      activate_selecting();
    } else {
      deactivate_selecting();
    }
  });
}
main();
