$(document).ready(function () {
    var loadingText = [
        "Shoveling coal into the server",
        "Nullifying disk",
        "Giving mysql a kick",
        "Wacking up apache",
        "Looking for that lost bit... found!"];
    var txtIdx;
    $('.ellipsis').hide();
    function setStatusMessage(auto) {
        $('#status').text(loadingText[txtIdx]);
        if((txtIdx + 1) < loadingText.length){
            setTimeout(function () {
                setStatusMessage(txtIdx++, true)
            }, 2000)
        } else {
            txtIdx = 0;
            setTimeout(function () {
                setStatusMessage(txtIdx, true)
            }, 2000)
        }
    }

    $(document).on('click','#create', function () {
        txtIdx = 0;
        $('.ellipsis').show();
        $('#create').attr('disabled', true);
        _paq.push(['trackEvent', 'Demo', 'Run']);
        setStatusMessage();
        $.post(post_url, $('#form').serialize(), function (data) {
            setInterval(function(){
                $.getJSON(status_url, function (data) {
                    console.log(data);
                    if(data.hasOwnProperty('port')) {
                        document.location.href = location.protocol + '//' + location.hostname + ':' + data.port;
                    } else {
                        $('#create').attr('disabled', false);
                        $('.ellipsis').hide();

                    }
                })
            }, 8500)
        })
    })
});