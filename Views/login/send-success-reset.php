<div class="text-center">

    <div class="avatar-md mx-auto">
        <div class="avatar-title rounded-circle bg-light">
            <i class="bx bx-check-shield h1 mb-0 text-primary"></i>
        </div>
    </div>
    <div class="p-2 mt-4">
        <h4>Success</h4>
        <p><?= isset($message) ? $message : "" ?></p>
        <div class="mt-4">
            <a href="<?= isset($url) ? $url : base_url() ?>" class="btn btn-success w-md"><?= isset($buttonText) ? $buttonText : "Kembali Ke Home"  ?></a>
        </div>
    </div>
</div>