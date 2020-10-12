@extends('layouts.app')
@section('content')

<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>


<div class="container-fluid">
    <div class="container-fluid">
        <div class="row">                                                           

            <div class="col-8 mx-auto">
                <div class="card">                    
                    <div class="card-header card-header-icon card-header-blue">
                        <div class="card-text">
                            <h4 class="card-title">ChatVideoCall</h4>
                        </div>
                        <a id="llamar" class="btn btn-primary pull-right" href="#"> 
                            <i class="fa fa-video-camera"> </i> Llamar 
                        </a>
                        <a id="colgar" class="btn btn-second pull-right btn-danger" href="" style="display:none;"> 
                            <i class="fa fa-window-close-o"> </i> Colgar 
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="col-md-12 row">
                            <div class="col-md-12">                                  
                                <video class="img-responsive" autoplay="true" muted="muted" id='localVideo'>
                                    Your browser does not support the video tag.
                                </video>
                                <video class="img-responsive" autoplay id='remoteVideo'>
                                    Your browser does not support the video tag.
                                </video>                                                            
                            </div>    
                        </div>
                    </div>                    
                    <h4 class="card-title">Chat</h4>
                    <input name="inputMessage" id="inputMessage"/>
                    <ul id="listMessages">
                    </ul>                    
                </div>                        
            </div> 
        </div>      
    </div>
</div>       
  
<div id="incomingVideoCallModal" class="modal fade" role="dialog">
    <div class="modal-dialog">        
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Incoming Call</h4>
            </div>
            <div class="modal-footer">
                <button type="button" id="answerCallButton" class="btn btn-success">Answer</button>
                <button type="button" id="denyCallButton" data-dismiss="modal" class="btn btn-danger">Deny</button>
            </div>
        </div>
    </div>
</div>

<input type="hidden" id="conversation" value="{{ $conversation }}">
<input type="hidden" id="currentUser" value="{{ $currentUser }}">

@endsection

@push('scripts')
<script type="text/javascript">
    $(function () {        
        var localVideo = document.getElementById('localVideo');
        var remoteVideo = document.getElementById('remoteVideo'); 
        listenForNewMessage();
    });
    
    var conversation = JSON.parse($('#conversation').val());
    var currentUser = JSON.parse($('#currentUser').val());        
    var remoteUserId = (currentUser.id === conversation.user1Id) ? conversation.user2Id : conversation.user1Id;     

    var offer_sdp = null;
    var candidatos = null;
    var files;
    var conversationID;
    var luid;
    var ruid;
    var startTime;
    var localStream;
    var pc;
    var offerOptions = {
        offerToReceiveAudio: 1,
        offerToReceiveVideo: 1
    };
    var isCaller = false;
    var peerConnectionDidCreate = false;
    var candidateDidReceived = false;
    var close_call = {subtype:'close'}; 
    
    $('#inputMessage').keyup(function(e){
        if(e.keyCode == 13) {            
            sendMessage($('#inputMessage').val());                        
            $('#listMessages').append( "<li class='' style='list-style-type:none; float:right; padding-right:40px;'>"+$('#inputMessage').val()+"</li><br>");                
            $('#inputMessage').val('');            
        }
    });

    function sendMessage(message) {           
        var data = {
            receiverId:remoteUserId,
            message:message
        };        
        axios.post('/chat/message/'+ conversation.id , data);
    }

    $('#llamar').on('click', function(e){
        e.preventDefault();    
        $('#colgar').css({"display":"block"});
        luid = currentUser.id;
        ruid = remoteUserId;
        isCaller = true;
        start();
    });

    $('#colgar').on('click', function(e){
        e.preventDefault();
        onSignalMessage(close_call);             
        var data = {
            receiverId:remoteUserId
        };
        axios.post('/call/hang/' + conversation.id , data);
    });

    $('#answerCallButton').on('click', function(e){
        e.preventDefault();
        isCaller = false;        
        luid = currentUser.id
        ruid = remoteUserId;
        $('#incomingVideoCallModal').modal('hide');
        $('#colgar').css({"display":"block"});
        start();
    });

    $('#denyCallButton').on('click', function(e){
        e.preventDefault();
    });
        

    function prepareUpload(event) {
        files = event.target.files;
    }
    function check(id) {
        return id === currentUser.id;
    }
    function send() {
        axios.post('/chat/message/send',{
            conversationId : conversation.id,
            text: this.text,
        }).then((response) => {
            this.text = '';
        });
    }

    function sendFiles() {
        var data = new FormData();
        $.each(files, function(key, value) {
            data.append('files[]', value);
        });
        data.append('conversationId' , conversation.id);
        axios.post('/chat/message/send/file', data);
    }

    function listenForNewMessage() {        
        Echo.channel("{{ env('REDIS_PREFIX', Str::slug(env('APP_NAME', 'Zukubo'), '_').'_database_') }}video_call_start."+conversation.id) 
            .listen('VideoChatEvent', (data) => {                        
            if(data.to != currentUser.id){
                return;
            }            
            if(data.type === 'signal'){
                onSignalMessage(data);
            }      
        });

        Echo.channel("{{ env('REDIS_PREFIX', Str::slug(env('APP_NAME', 'Zukubo'), '_').'_database_') }}video_call_hang."+conversation.id) 
            .listen('VideoChatEvent', (e) => {            
            onSignalMessage(close_call);                                                
        }); 

        Echo.channel("{{ env('REDIS_PREFIX', Str::slug(env('APP_NAME', 'Zukubo'), '_').'_database_') }}chat_send."+conversation.id)         
            .listen('VideoChatEvent', (data) => {                       
            if(data.to != currentUser.id){
                return;
            }
            $('#listMessages').append( "<li class='' style='list-style-type:none; float:left;'>"+data.message+"</li><br>" );                                                                      
        });        
    }

    function beforeMount () {
        luid = currentUser.id;
        
    }
    function mounted() {
        this.listenForNewMessage();
    }

    function onSignalMessage(m){        
        if(m.subtype === 'offer'){
            console.log('got remote offer from ' + m.from + ', content ' + m.content);            
            remoteUserId = m.from;
            onSignalOffer(m.content);            
        }else if(m.subtype === 'answer'){
            onSignalAnswer(m.content);
        }else if(m.subtype === 'candidate'){
            onSignalCandidate(m.content);
        }else if(m.subtype === 'close'){
            onSignalClose();
        }else{
            console.log('unknown signal type ' + m.subtype);
        }
    }
    
    function onSignalClose() {
        trace('Ending call');               
        if (pc != null) {
            pc.close();                   
        }            
        closeMedia();
        clearView();
        $('#colgar').css({"display":"none"});
        $('#incomingVideoCallModal').modal('hide');        
    }

    function closeMedia(){
        localStream.getTracks().forEach(function(track){track.stop();});
    }

    function clearView(){
        localVideo.srcObject = null;
        remoteVideo.srcObject = null;
    }

    function onSignalCandidate(candidate){
        onRemoteIceCandidate(candidate);
    }

    function onRemoteIceCandidate(candidate){
        trace('onRemoteIceCandidate : ' + candidate);
        if(peerConnectionDidCreate){
            addRemoteCandidate(candidate);
        }else{            
            var candidates = candidatos;
            
            if(candidateDidReceived){
                candidates.push(candidate);
            }else{
                candidates = [candidate];
                candidateDidReceived = true;
            }            
            candidatos = candidates;
            
        }
    }

    function onSignalAnswer(answer){
        onRemoteAnswer(answer);
    }

    function onRemoteAnswer(answer){
        trace('onRemoteAnswer : ' + answer); 
               
        answer.sdp += '\n';
        pc.setRemoteDescription(answer).then(function(){onSetRemoteSuccess(pc)}, onSetSessionDescriptionError);
    }

    function onSignalOffer(offer){                
        offer_sdp = offer;        

        $('#incomingVideoCallModal').modal('show');
    }

    function gotStream(stream) {
        trace('Received local stream');
        localVideo.srcObject = stream;
        localStream = stream;        
        call();
    }

    function start() {
        trace('Requesting local stream');
        navigator.mediaDevices.getUserMedia({
            // audio: true,
            audio: {
                echoCancellationType: 'system',
                echoCancellation: true,
                noiseSuppression: true,                
                sampleRate:24000,
                sampleSize:16,
                channelCount:2,
                volume:0.5                                
            },
            video: {
                width: {
                    exact: 320
                },
                height: {
                    exact: 240
                }
            }
        })
        .then(gotStream)
        .catch(function(e) {
            alert('getUserMedia() error: ' + e.name);
        });
    }

    function call() {        
        trace('Starting call');
        startTime = window.performance.now();
        var videoTracks = localStream.getVideoTracks();
        var audioTracks = localStream.getAudioTracks();
        if (videoTracks.length > 0) {
            trace('Using video device: ' + videoTracks[0].label);
        }
        if (audioTracks.length > 0) {
            trace('Using audio device: ' + audioTracks[0].label);
        }
                
        var configuration = {
            'iceServers': [
                {"urls":"stun:chatvideollamada.zukubo.com:3478"},
                {"username":"guest","credential":"pass1234",urls:["turn:chatvideollamada.zukubo.com:3478"]}

            ],
        };

        pc = new RTCPeerConnection(configuration);
        trace('Created local peer connection object pc');
        pc.onicecandidate = function(e) {
            onIceCandidate(pc, e);
        };
        pc.oniceconnectionstatechange = function(e) {
            onIceStateChange(pc, e);
        };
        pc.onaddstream = gotRemoteStream;
        pc.addStream(localStream);
        trace('Added local stream to pc');
        peerConnectionDidCreate = true;

        if(isCaller) {
            trace(' createOffer start');
            trace('pc createOffer start');

            pc.createOffer(
                offerOptions
            ).then(
                onCreateOfferSuccess,
                onCreateSessionDescriptionError
            );
        }else{
            onAnswer()
        }
    }

    function onAnswer(){                   
        offer_sdp.sdp += '\n';    
        pc.setRemoteDescription(offer_sdp).then(function(){onSetRemoteSuccess(pc)}, onSetSessionDescriptionError);
        pc.createAnswer().then(
            onCreateAnswerSuccess,
            onCreateSessionDescriptionError
        );
    }

    function onCreateAnswerSuccess(desc) {
        trace('Answer from pc:\n' + desc.sdp);
        trace('pc setLocalDescription start');
        pc.setLocalDescription(desc).then(
            function() {
                onSetLocalSuccess(pc);
            },
            onSetSessionDescriptionError
        );

        var data = {
            from:luid, 
            to:ruid, 
            type:'signal', 
            subtype:'answer', 
            content:desc, 
            time:new Date(),
            receiverId:remoteUserId,
        };
        
        axios.post('/trigger/' + conversation.id , data );
    }

    function onSetRemoteSuccess(pc) {
        trace(pc + ' setRemoteDescription complete');
        applyRemoteCandidates();
    }

    function applyRemoteCandidates(){        
        var candidates = candidatos;
        for(var candidate in candidates){
            addRemoteCandidate(candidates[candidate]);
        }
        
    }

    function addRemoteCandidate(candidate){
        pc.addIceCandidate(candidate).then(
            function() {
                onAddIceCandidateSuccess(pc);
            },
            function(err) {
                onAddIceCandidateError(pc, err);
            });
    }

    function onIceCandidate(pc, event) {
        if (event.candidate){
            trace(pc + ' ICE candidate: \n' + (event.candidate ? event.candidate.candidate : '(null)'));
            
            var message = {
                from:luid, 
                to:ruid, 
                type:'signal', 
                subtype:'candidate', 
                content:event.candidate, 
                time:new Date(),
                receiverId:remoteUserId,                
            };
            axios.post('/trigger/' + conversation.id , message );
        }
    }

    function onAddIceCandidateSuccess(pc) {
        trace(pc + ' addIceCandidate success');
    }

    function onAddIceCandidateError(pc, error) {
        trace(pc + ' failed to add ICE Candidate: ' + error.toString());
    }

    function onIceStateChange(pc, event) {
        if (pc) {
            trace(pc + ' ICE state: ' + pc.iceConnectionState);
            console.log('ICE state change event: ', event);
        }
    }

    function onCreateSessionDescriptionError(error) {
        trace('Failed to create session description: ' + error.toString());
    }

    function onCreateOfferSuccess(desc) {
        trace('Offer from pc\n' + desc.sdp);
        trace('pc setLocalDescription start');
        pc.setLocalDescription(desc).then(
            function() {
                onSetLocalSuccess(pc);
            },
            onSetSessionDescriptionError
        );
        
        var message = {
            from:luid, 
            to:ruid, 
            type:'signal', 
            subtype:'offer', 
            content:desc, 
            time:new Date(),
            receiverId:remoteUserId,
        };
        axios.post('/trigger/' + conversation.id , message );
    }

    function onSetLocalSuccess(pc) {
        trace( pc + ' setLocalDescription complete');
    }

    function onSetSessionDescriptionError(error) {
        trace('Failed to set session description: ' + error.toString());
    }

    function gotRemoteStream(e) {
        if (remoteVideo.srcObject !== e.stream) {
            remoteVideo.srcObject = e.stream;
            trace('pc received remote stream');
        }
    }

    function trace(arg) {
        var now = (window.performance.now() / 1000).toFixed(3);
        console.log(now + ': ', arg);
    }
    
    
</script>
@endpush
