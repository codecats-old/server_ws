<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
Hello
<div></div>
<script>
var ws = new WebSocket('ws://localhost:5000/ws');

ws.onopen = function () {
alert('open');
}

ws.onmessage = function(ev){
    var msg = JSON.parse(ev.data);
    $('div').append(msg.msg);
}
</script>
