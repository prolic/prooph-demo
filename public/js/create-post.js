$(function() {
  $.postJSON = function(url, data, settings) {
      if (typeof settings == 'undefined') settings = {};
      return $.ajax(url, $.extend({
          contentType : 'application/json; charset=UTF-8',
          type: "POST",
          data : JSON.stringify(data),
          dataType : 'json',
          dataFilter : function (data, dataType) {
              if (! data && dataType == "json") return "{}";
              return data;
          }
      }, settings))
  };
  $("#submitPostForm input,#submitPostForm textarea").jqBootstrapValidation({
    preventSubmit: true,
    submitError: function($form, event, errors) {
      // additional error messages or events
    },
    submitSuccess: function($form, event) {
      console.log('ok2');
      event.preventDefault(); // prevent default submit behaviour
      // get values from FORM
      var postId = UUID();
      var title = $("input#title").val();
      var content = $("textarea#content").val();
      $this = $("#submitPostButton");
      $this.prop("disabled", true); // Disable submit button until AJAX call is complete to prevent duplicate messages
      $.postJSON("/api/create-post", {
        postId: postId,
        title: title,
        content: content
      }).then(
        function () {
          // Success message
          $('#success').html("<div class='alert alert-success'>");
          $('#success > .alert-success').html("<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;")
            .append("</button>");
          $('#success > .alert-success')
            .append("<strong>Your post has been submitted. You are being redirected... </strong>");
          $('#success > .alert-success')
            .append('</div>');
          //clear all fields
          setTimeout(function () {
            window.location.href = '/';
          }, 2000);
        },
        function () {
          $('#success').html("<div class='alert alert-danger'>");
          $('#success > .alert-danger').html("<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;")
            .append("</button>");
          $('#success > .alert-danger').append($("<strong>").text("Sorry, it seems that there is an error. Please try again later!"));
          $('#success > .alert-danger').append('</div>');
          //clear all fields
          $('#submitPostForm').trigger("reset");
          $('#submitPostButton').removeAttr('disabled');
        }
      );
    },
    filter: function() {
      return $(this).is(":visible");
    }
  });
});

/*When clicking on Full hide fail/success boxes */
$('#title').focus(function() {
  $('#success').html('');
});
