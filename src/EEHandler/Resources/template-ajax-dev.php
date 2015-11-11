<?php echo $this->message; ?> - <?php echo $this->headline; ?>
<?php if($this->fileCousingError): ?>
    File: <?php echo $this->fileCousingError; ?>
<?php endif; ?>
<?php if($this->errorLine): ?>
    Line: <?php echo $this->errorLine; ?>
<?php endif; ?>
