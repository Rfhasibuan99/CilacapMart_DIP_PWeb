<?=  $this->extend('layout/template'); ?>
<?=  $this->section('content'); ?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Chat<?= esc(user()->username) ?></title>
<meta name="viewport" content="width=device-width, initial-scale=1">


<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">


<meta name="csrf-name" content="<?= csrf_token() ?>">
<meta name="csrf-hash" content="<?= csrf_hash() ?>">
</head>
<body>
  <style>body { background:#fafafa; font-family: system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial; }

#usersList .user-item { cursor:pointer; padding:10px 12px; border-radius:8px; display:flex; gap:10px; align-items:center; }
#usersList .user-item:hover { background: #fff; }

.user-avatar { width:48px; height:48px; border-radius:50%; background:#6c757d; color:#fff; display:flex; align-items:center; justify-content:center; font-weight:600; }

.user-info { flex:1; min-width:0; }
.user-name { font-weight:600; }
.user-last { font-size:12px; color:#6c757d; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; }

.badge-unread { background:#0d6efd; color:#fff; padding:3px 7px; border-radius:999px; font-size:12px; }

.online-dot { width:10px; height:10px; border-radius:50%; background:#28a745; display:inline-block; margin-right:6px; }

.message { display:inline-block; padding:10px 14px; border-radius:12px; margin:6px 0; max-width:70%; line-height:1.2; }
.message.me { background:#dcf8c6; align-self:flex-end; float:right; border-bottom-right-radius:4px; }
.message.other { background:#fff; align-self:flex-start; float:left; border-bottom-left-radius:4px; }

#chatBox { display:flex; flex-direction:column; gap:6px; padding:20px; }


@media (max-width: 767px) {
  #usersList { display:block; }
  .col-md-8.col-lg-9 { display:block; }
}
</style>
<div class="container-fluid vh-100">
  <div class="row h-100">
    <div class="col-12 col-md-4 col-lg-3 border-end p-0 d-flex flex-column" style="background:#f7f7f7;">
      <div class="p-3 border-bottom d-flex align-items-center">
        <div class="me-2">
          <div class="rounded-circle bg-secondary text-white d-flex align-items-center justify-content-center" style="width:44px;height:44px">
            <?= strtoupper(substr(user()->username,0,1)) ?>
          </div>
        </div>
        <div>
          <div class="fw-bold"><?= esc(user()->username) ?></div>
          <div class="text-muted small">Online</div>
        </div>
      </div>

      <div class="p-2">
        <input id="searchUser" class="form-control" placeholder="Cari user..." />
      </div>

      <div id="usersList" class="overflow-auto flex-grow-1" style="min-height:0;"></div>
    </div>

    <div class="col-12 col-md-8 col-lg-9 d-flex flex-column p-0">
      <div id="chatHeader" class="p-3 border-bottom d-flex align-items-center">
        <button id="backBtn" class="btn btn-light btn-sm d-md-none me-2" style="display:none;"><i class="bi bi-arrow-left"></i></button>
        <div id="chatPartner" class="d-flex align-items-center">
          <?php if(isset($receiver_id) && $receiver_id): ?>
            <?php $r = (new \App\Models\AkunModel())->getAkunById($receiver_id); ?>
            <div class="me-2 user-avatar" style="width:40px;height:40px"><?= $r ? strtoupper(substr($r['username'],0,1)) : 'U' ?></div>
            <div>
              <div class="fw-bold"><?= $r ? esc($r['username']) : 'User' ?></div>
              <div class="text-muted small">Personal chat</div>
            </div>
          <?php endif; ?>
        </div>
      </div>

      <div id="chatBox" class="flex-grow-1 overflow-auto p-3" style="background:#e9e5df"></div>

      <div class="p-2 border-top bg-white">
        <div class="input-group">
          <input id="messageInput" type="text" class="form-control" placeholder="Ketik pesan..." autocomplete="off" />
          <button id="sendBtn" class="btn btn-primary"><i class="bi bi-send"></i></button>
        </div>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
const currentUser = <?= json_encode(user()->id) ?>;
let currentPartner = <?= isset($receiver_id) ? (int)$receiver_id : 0 ?>;
</script>

<script>
  document.addEventListener('DOMContentLoaded', function(){

  const usersListEl = document.getElementById('usersList');
  const chatBox = document.getElementById('chatBox');
  const chatHeader = document.getElementById('chatPartner');
  const messageInput = document.getElementById('messageInput');
  const sendBtn = document.getElementById('sendBtn');
  const searchUser = document.getElementById('searchUser');
  const backBtn = document.getElementById('backBtn');

  let evtSource = null;
  let currentStreamPartner = null;

  function fmtTime(dtStr){
    if(!dtStr) return '';
    const d = new Date(dtStr);
    return d.toLocaleTimeString();
  }

  async function loadUsers(q = ''){
    const res = await fetch('/chat/users');
    const users = await res.json();

    usersListEl.innerHTML = '';
    users.forEach(u => {
      if(q && u.username.toLowerCase().indexOf(q.toLowerCase()) === -1) return;
      const div = document.createElement('div');
      div.className = 'user-item d-flex align-items-center justify-content-between';

      const left = document.createElement('div');
      left.className = 'd-flex align-items-center';

      const avatar = document.createElement('div');
      avatar.className = 'user-avatar me-2';
      avatar.textContent = (u.username ? u.username.substr(0,1).toUpperCase() : 'U');

      const info = document.createElement('div');
      info.className = 'user-info';

      const nameRow = document.createElement('div');
      nameRow.className = 'd-flex align-items-center';

      if(u.online){
        const dot = document.createElement('span');
        dot.className = 'online-dot';
        nameRow.appendChild(dot);
      }

      const name = document.createElement('div');
      name.className = 'user-name';
      name.textContent = u.username;
      nameRow.appendChild(name);

      info.appendChild(nameRow);

      const last = document.createElement('div');
      last.className = 'user-last';
      last.textContent = u.last_message ? u.last_message : '—';
      info.appendChild(last);

      left.appendChild(avatar);
      left.appendChild(info);

      const right = document.createElement('div');
      right.className = 'text-end';

      if(u.unread && u.unread > 0){
        const b = document.createElement('span');
        b.className = 'badge-unread';
        b.textContent = u.unread;
        right.appendChild(b);
      }

      div.appendChild(left);
      div.appendChild(right);

      div.addEventListener('click', () => {
        openChat(u.id, u.username);
      });

      usersListEl.appendChild(div);
    });
  }

  searchUser.addEventListener('input', (e) => loadUsers(e.target.value));

  function openChat(partnerId, partnerName){
    currentPartner = partnerId;
    chatHeader.innerHTML = `<div class="me-2 user-avatar" style="width:40px;height:40px">${partnerName.substr(0,1).toUpperCase()}</div>
                            <div><div class="fw-bold">${partnerName}</div>
                            <div class="text-muted small">Personal chat</div></div>`;
    if(backBtn) backBtn.style.display = 'inline-block';
    chatBox.innerHTML = '';
    startStream(partnerId);
  }

  function startStream(partnerId){
    if(evtSource){
      evtSource.close();
      evtSource = null;
    }
    currentStreamPartner = partnerId;
    evtSource = new EventSource('/chat/stream/' + partnerId);

    evtSource.onmessage = function(e){
      try {
        const msgs = JSON.parse(e.data);
        msgs.forEach(m => appendMessage(m));
        chatBox.scrollTop = chatBox.scrollHeight;
      } catch(err){}
    };

    evtSource.onerror = function(e){
      console.error('SSE error', e);
    };
  }

  function appendMessage(m){
    const div = document.createElement('div');
    div.className = 'd-flex flex-column';
    const bubble = document.createElement('div');
    bubble.className = 'message ' + (m.sender_id == currentUser ? 'me' : 'other');
    bubble.innerHTML = `<div>${escapeHtml(m.message)}</div><div style="font-size:10px;color:#666;margin-top:4px;text-align:${m.sender_id==currentUser?'right':'left'}">${fmtTime(m.created_at)}</div>`;
    div.appendChild(bubble);
    chatBox.appendChild(div);
  }

  function escapeHtml(str){
    if(!str) return '';
    return str.replace(/[&<>"'`=\/]/g, function(s){ return ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;','/':'&#x2F;','`':'&#x60;','=':'&#x3D;'})[s]; });
  }

  async function sendMessage(){
    const txt = messageInput.value.trim();
    if(!txt || !currentPartner) return;

    const csrfName = document.querySelector('meta[name="csrf-name"]')?.getAttribute('content');
    const csrfHash = document.querySelector('meta[name="csrf-hash"]')?.getAttribute('content');

    const bodyParams = new URLSearchParams({
      message: txt,
      receiver_id: currentPartner
    });

    if (csrfName && csrfHash) {
      bodyParams.append(csrfName, csrfHash);
    }

    await fetch('/chat/send', {
      method: 'POST',
      headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
      body: bodyParams.toString()
    });

    messageInput.value = '';
  }

  sendBtn.addEventListener('click', sendMessage);
  messageInput.addEventListener('keypress', function(e){
    if(e.key === 'Enter') sendMessage();
  });

  if(backBtn) backBtn.addEventListener('click', function(){
    if(evtSource) { evtSource.close(); evtSource = null; }
    currentStreamPartner = null;
    chatBox.innerHTML = '';
    chatHeader.innerHTML = '';
    backBtn.style.display = 'none';
  });


  setInterval(function(){
    fetch('/chat/ping', { method: 'POST' });
    loadUsers(searchUser.value || '');
  }, 15000);


  loadUsers();

  if(typeof currentPartner !== 'undefined' && currentPartner && currentPartner !== 0){
    fetch('/chat/users').then(r => r.json()).then(list => {
      const p = list.find(u => u.id == currentPartner);
      const name = p ? p.username : 'User';
      openChat(currentPartner, name);
    });
  }

});
</script>
</body>
</html>
<?=  $this->endSection(); ?>