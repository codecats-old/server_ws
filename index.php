<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
<link href="jquery.cssemoticons.css" media="screen" rel="stylesheet" type="text/css" />

<script src="jquery.cssemoticons.js" type="text/javascript"></script>

Users:
<ul></ul>
Messages:
<div id="my"></div>
<button>Send</button>
<textarea></textarea>
<script>

function addUser(user, myself) {
    if ($('ul li[value="' + user.id + '"]').length === 0) {
        if (user.id === myself) {
            myself = '#';
        } else {
            myself = '';
        }
    	$('ul').append('<li value="' + user.id + '"><img width="50px" src="data:image/png;base64,' + user.avatar + '" />' + myself + user.name + ': ' + user.id + '</li>');
    }
}
function getAvatar(id) { 
    return $('ul li[value="' + id + '"]>img').clone();
}
var ws = new WebSocket('ws://localhost:5001/ws');
ws.user = null;
$('button').hide();

ws.onopen = function (ev) {
    $('button').show();
}

ws.onmessage = function(ev){
    var msg = JSON.parse(ev.data);
    if (msg.msg){
        $('div').append([getAvatar(msg.sender.id), msg.sender.id + '- ' + msg.msg + '<br />'])
        $('div').emoticonize();

    }
    if (msg.received) {
    	$('div').append('✓ <br />');
        $('div').emoticonize();
    }
    if (msg.user) {
    	addUser(msg.user);
    }
    if (msg.users) {
        ws.user = msg.myself;
    	$('ul li').remove();
    	for (var user in msg.users) {
    		addUser(msg.users[user], msg.myself)
    	}
    	
    }
    if (msg.user_remove) {
    	$('ul li[value="' + msg.user_remove.id + '"]').remove();
    }
}
$('button').click(function () {
    $('div').append([getAvatar(ws.user), ' ', $('textarea').val()])
    $('div').emoticonize();
	ws.send($('textarea').val());
    
});
</script>
