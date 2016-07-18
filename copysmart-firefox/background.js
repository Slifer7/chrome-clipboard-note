chrome.contextMenus.create({
    title: 'Envoyer vers CopySmart',
    id: 'menu1', // you'll use this in the handler function to identify this context menu item
    contexts: ['selection'],
});

chrome.contextMenus.onClicked.addListener(function(info, tab) {
    if (info.menuItemId === "menu1") { // here's where you'll need the ID
      chrome.storage.local.set({ // Đưa vào storage để truyền qua trang
         clipdata: info.selectionText
       }, function() {
         chrome.tabs.create({'url': chrome.extension.getURL('popup.html')});
       });
    }
});
