<?=$this->extend('layout/template');?>
<?=$this->section('content');?>
    <style>
        body {
            background: #ffffff;
        }

        .chat-container {
            max-width: 900px;
            margin: auto;
            padding-top: 20px;
        }

        .bubble-left {
            background: #0096C7;
            color: #fff;
            padding: 18px;
            border-radius: 15px;
            width: 80%;
            margin-bottom: 20px;
        }

        .bubble-right {
            background: #FDC500;
            color: #000;
            padding: 18px;
            border-radius: 15px;
            width: 80%;
            margin-bottom: 20px;
            margin-left: auto;
        }

        .chat-input-area {
            position: fixed;
            bottom: 20px;
            left: 0;
            right: 0;
            width: 100%;
        }

        .chat-input-wrapper {
            max-width: 900px;
            margin: auto;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .chat-input {
            background: #E0F2FE;
            border: 1px solid #0096C7;
            border-radius: 8px;
            padding-left: 15px;
        }

        .plus-btn, .emoji-btn {
            background: none;
            border: none;
            font-size: 26px;
            cursor: pointer;
        }

        .back-text {
            font-size: 20px;
            cursor: pointer;
            font-weight: bold;
        }
    </style>

<div class="chat-container">

    <!-- Kembali -->
    <div class="back-text mb-3" onclick="history.back()">
        ← Kembali
    </div>

    <h3 class="text-center fw-bold mb-4">Nama Toko</h3>

    <!-- CHAT BUBBLES (contoh statis) -->
    <div class="bubble-left"></div>

    <div class="bubble-right"></div>

    <div class="bubble-left"></div>

    <div class="bubble-right"></div>

</div>

<!-- INPUT CHAT -->
<div class="chat-input-area">
    <div class="chat-input-wrapper">

        <button class="plus-btn">＋</button>

        <input type="text" class="form-control chat-input" placeholder="Ketik disini">

        <button class="emoji-btn">🙂</button>

    </div>
</div>

<?=$this->endSection();?>