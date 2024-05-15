// current url + parameter
function loadBody(body, element) {
  if (element) {
    element = $(element);
    $(".aside-pages").each((idx, element) => {
      if ($(element).hasClass("aside-pages-active")) {
        $(element).removeClass("aside-pages-active");
      }
    });
    element.addClass("aside-pages-active");
  }

  var bodyUrl = `components/body_${body}.php`;
  $(".loading-layer").removeClass("loading-layer-hide");
  $(".middle-section").load(bodyUrl);
}

//------------------ onload page --------------------//
$(document).ready(() => {
  // load dashboard body
  loadBody("profile", $(".aside-pages").children().prevObject[5]);

  //
  showAddNewNoteForm(false);

  //
  showMessageAlert("", 0, false);
});

// show message box
function showMessageAlert(message, times, show, color) {
  var messageBox = $(".small-message-box");

  if (show && message) {
    messageBox.children("p").text(message);
    messageBox.show();

    if (color) {
      messageBox.css("--message-box-color", color);
    } else {
      messageBox.css("--message-box-color", "green");
    }

    setTimeout(() => {
      messageBox.hide();
    }, times);
  } else {
    messageBox.hide();
  }
}

// show add new note form
function showAddNewNoteForm(show) {
  if (show) {
    $(".add-new-note-floating-layer").show();
  } else {
    $(".add-new-note-floating-layer").hide();
  }
}

// get new note
function addNewNote(event) {
  event.preventDefault();
  var formData = $("#add-new-note-form").serialize();

  console.log(formData);

  $.ajax({
    type: "POST",
    url: "../Server/api/addNewNoteController.php",
    data: formData,
    success: function (response) {
      console.log(response);
      try {
        response = JSON.parse(response);
        if (response.status == "success") {
          console.log(response);
          showAddNewNoteForm(false);
          loadBody("dashboard", $(".aside-pages").children().prevObject[0]);
        }
        showMessageAlert(response.message, 3000, true, "green");
      } catch (error) {
        console.log(error);
      }
    },
  });
}
