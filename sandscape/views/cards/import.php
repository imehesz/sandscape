<h2>Import Cards</h2>
<?php if ($success) { ?>
    <div>Cards were successfully imported.</div>
<?php } ?>
<p>
    You can submit a <strong>zip</strong> file containing <strong>one CSV file</strong> 
    named <em>cards.csv</em> with the card's information and <strong>one folder</strong>, 
    named <em>images</em>, with the card images. The images will be resized if they are 
    bigger than the maximum width and height and thumbnails will be generated automatically.
</p>
<p>
    The CSV structure is:
    <code>
        name,rules,image file,cardscape ID
    </code>
</p>
<p>
    Only the <em>cardscape ID</em> is optional, all other attributes are required. 
    The image file should be the name of the file found in the <em>images</em> folder.
</p>
<p>
    Uploading files is limited by your server's settings. If you are unable to send big files, 
    consider splitting the archive in smaller files.
</p>

<?php echo CHtml::form($this->createUrl('cards/import'), 'post', array('enctype' => 'multipart/form-data')); ?>
<fieldset>
    <legend>Zip File</legend>
    <div class="formrow">
        <?php echo CHtml::label('File', 'archive'), '<br />', Chtml::fileField('archive'); ?>
    </div>
    <?php
    if (count($saveErrors)) {
        foreach ($saveErrors as $serror) {
            ?>
            <div><?php echo $serror; ?></div>
            <?php
        }
    }

    if ($uError) {
        ?>
        <div><?php echo $uError; ?></div>
    <?php } ?>
</fieldset>
<div class="buttonrow">
    <?php echo CHtml::submitButton('Upload', array('class' => 'button', 'name' => 'Upload')); ?>
</div>

<?php
echo CHtml::endForm();