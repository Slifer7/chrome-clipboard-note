function Load()
{
  chrome.storage.local.get(null,function(items) {
      $("#txtUsername").val(items.username);
      $("#txtPassword").val(items.password);
    }
  );
}

function Save()
{
    var username = $("#txtUsername").val();
    var password = $("#txtPassword").val();

    chrome.storage.local.set({
       username: username,
       password: password,
     }, function() {
       $("#divInfo").toggleClass("hidden");
     });

     return false;
}

$(document).ready(function(){
  $("#btnSave").click(Save);
  Load();
});
