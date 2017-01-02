/**
 * Database of the docker demo site
 * Copyright (C) 2016  Marcos Zuriaga Miguel <wolfi at wolfi.es>
 * Copyright (C) 2016  Sander Brand <brantje at gmail.com>
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as published
 * by the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with this program. If not, see <http://www.gnu.org/licenses/>.
 */

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
        _paq.push(['trackEvent', 'container', 'start']);
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