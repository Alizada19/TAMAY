<div style="margin-top:10%;text-align:center;">
    <h2>Upload Excel File</h2>
	<div style="color: green; font-weight: bold;">
        <?= session()->getFlashdata('success') ?>
    </div>
    <form action="<?= base_url('codeigniter/public/uploadexcel/excel') ?>" method="post" enctype="multipart/form-data">
        <input type="file" name="file" accept=".xls,.xlsx" required>
        <button type="submit">Upload</button>
    </form>
</div>
