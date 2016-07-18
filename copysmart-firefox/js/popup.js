function Load()
{
  chrome.storage.local.get(null, function(items) {
      gUsername = items.username;
      gPassword = items.password;
      $('#summernote').summernote('code', items.clipdata);
    }
  );
}

var gUsername;
var gPassword;
var URL = "http://app.copysmart.io/savenote.php";

function Save(){
  $.ajax({
    "url": URL,
    "type" : "POST",
    "data" : {
      username: gUsername,
      password: gPassword,
      text    : $('#summernote').summernote('code'),
      tags: $("#txtTags").val()
    },
    "success" : function(data){
      var result = JSON.parse(data);
      alert(result.ErrorMessage);

      if (result.OK){ // Close current tab
        chrome.tabs.query({currentWindow: true}, function(tabs) {
          for (var tab of tabs) {
            if (tab.active) {
               chrome.tabs.remove(tab.id);
            }
          }
        });
      }
    }
  });
}

$(document).ready(function(){
  Load();
  $("#btnSend").click(Save);
});
