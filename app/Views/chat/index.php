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

<link rel="stylesheet" href="/css/chat.css">
</head>
<body>
<div class="container-fluid vh-100">
  <div class="row h-100">
    <!-- SIDEBAR -->
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

    <!-- CHAT AREA -->
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

<script src="/js/chat-main.js"></script>
</body>
</html>
<?=  $this->endSection(); ?>