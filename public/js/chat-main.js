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
