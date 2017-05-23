//Opening the page with favourite websites
chrome.browserAction.onClicked.addListener(function(activeTab){
    chrome.tabs.create({ url: "Tagged.html"});
});
