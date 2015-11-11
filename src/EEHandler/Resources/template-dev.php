<?php
    $brushesTypes = [
        'php'  => 'php',
        'php4' => 'php',
        'php5' => 'php',
        'tpl'  => 'html',
        'html' => 'html',
        'htm'  => 'html',
        'xml'  => 'xml',
        'js'   => 'js',
        'css'  => 'css'
    ];
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>500 - Internal Server Error</title>
        <script>
        <?php
            $files = [
                $ROOT.'/Resources/assets/jquery.min.js',
                $ROOT.'/Resources/assets/syntaxhighlighter/js/shCore.js',
                $ROOT.'/Resources/assets/syntaxhighlighter/js/shBrushXml.js',
                $ROOT.'/Resources/assets/syntaxhighlighter/js/shBrushSql.js',
                $ROOT.'/Resources/assets/syntaxhighlighter/js/shBrushPhp.js',
                $ROOT.'/Resources/assets/syntaxhighlighter/js/shBrushJScript.js',
                $ROOT.'/Resources/assets/syntaxhighlighter/js/shBrushGroovy.js',
                $ROOT.'/Resources/assets/syntaxhighlighter/js/shBrushCss.js'
            ];

            foreach($files as $file)
            {
                echo file_get_contents($file);
            }
        ?>
        </script>
        <style>
        <?php
            $files = [
                $ROOT.'/Resources/assets/syntaxhighlighter/css/shCore.css',
                $ROOT.'/Resources/assets/syntaxhighlighter/css/shCoreMonokai.css',
                $ROOT.'/Resources/assets/syntaxhighlighter/css/shThemeMonokai.css'
            ];

            foreach($files as $file)
            {
                echo file_get_contents($file);
            }
        ?>
        body {margin:0 auto;width:996px;max-width:100%;font-family:Arial,Tahoma,Verdana;font-size:12px;color:#000;line-height:1.3;padding:0;background-color:#34352E;color:#f1f1f1;}
        body, body * {box-sizing:border-box;-moz-box-sizing:border-box;webkit-box-sizing:border-box;}
        header {background:#000;padding:20px;margin-bottom:20px;}
        header h1 {font-size:23px;color:#fff;margin:0;padding:0;}
        header h1 small {font-size:15px;font-weight:bold;opacity:.5;display:block;margin-top:5px;}
        header .details {margin-top:7px;opacity:.8}
        header .details .name {display:inline-block;margin-right:3px;font-weight:bold;}
        header .details .value {display:inline-block;margin-right:20px;}
        h2 {font-size:19px;text-shadow:0 1px 1px rgba(0,0,0,.7);}
        .tabs-container {position:relative;padding:0 20px;}
        .tabs-container:after {display:table;clear:both;content:" ";}
        .tabs-container .tabs-list {width:30%;float:left;}
        .tabs-container .tabs-list ul,
        .tabs-container .tabs-list li {display:block;margin:0;padding:0;float:none;}
        .tabs-container .tabs-list ul {border:1px solid #272723;border-bottom:4px solid #272723;}
        .tabs-container .tabs-list li {padding:10px;border-top:1px solid #3C3E34;border-bottom:1px solid #272723;text-shadow:0 1px 1px rgba(0,0,0,.7);position:relative;}
        .tabs-container .tabs-list li:after {display:none;content:" ";position:absolute;right:-10px;top:50%;margin-top:-22px;width:0;height:0;border-style:solid;border-width:22px 0 22px 9px;border-color:transparent transparent transparent #272723;}
        .tabs-container .tabs-list li:last-child {border-bottom:none;}
        .tabs-container .tabs-list li h4 {margin:0;font-size:16px;font-weight:bold;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;position:relative;}
        .tabs-container .tabs-list li .line {font-size:11px;margin:4px 0 0 5px;opacity:.6;font-weight:normal;float:right;display:inline-block;}
        .tabs-container .tabs-list li:hover {cursor:pointer;}
        .tabs-container .tabs-list li.active {background-color:#393B2F;}
        .tabs-container .tabs-list li.active:after {display:block;}
        .tabs-container .tabs-list li.active h4 .line {opacity:1;}
        .tabs-container .tabs-list li.active .file-path {opacity:1;}
        .tabs-container .tabs-content {width:70%;float:right;padding-left:20px;}
        .tabs-container .tabs-content .tab {display:none;}
        .tabs-container .tabs-content .tab.active {display:block;}
        footer {background-color:#000;padding:12px;margin-top:20px;color:#aaa;}
        footer a {color:#ccc;font-weight:bold;text-decoration:none;}
        footer .generated-at {float:right;}

        .preview-not-available {font-weight:bold;margin:20px 0;text-transform:uppercase;font-size:15px;}

        .variable-print {position:relative;overflow:auto;border:1px solid #272723;border-bottom:4px solid #272723;padding:0 20px;}

        .syntaxhighlighter {margin:0 !important;border:1px solid #272723 !important;border-bottom:4px solid #272723 !important;}
        </style>
    </head>
    <body>
        <header>
            <h1><?php echo $this->message; ?><small><?php echo $this->headline; ?></small></h1>
            <div class="details">
                <?php if($this->fileCousingError): ?>
                    <span class="name">File:</span>
                    <span class="value"><?php echo $this->fileCousingError; ?></span>
                <?php endif; ?>
                <?php if($this->errorLine): ?>
                    <span class="name">Line:</span>
                    <span class="value"><?php echo $this->errorLine; ?></span>
                <?php endif; ?>
            </div>
        </header>
        <div class="tabs-container">
            <h2>Backtrace</h2>
            <div class="tabs-list">
                <ul>
                    <?php foreach($this->backtrace as $i => $item): ?>
                        <li data-tab="syntax-<?php echo $i; ?>">
                            <span class="line">Line <?php echo $item['line']; ?></span>
                            <h4 title="<?php echo $item['file-name']; ?>.<?php echo $item['file-extension']; ?>"><?php echo $item['file-name']; ?><?php echo $item['file-extension'] ? '.'.$item['file-extension'] : ''; ?></h4>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <div class="tabs-content">
                <?php foreach($this->backtrace as $i => $item): ?>
                    <div class="tab syntax" id="tab-syntax-<?php echo $i; ?>">
                        <?php if($item['source']): ?>
                            <pre class="brush: <?php echo (isset($brushesTypes[$item['file-extension']]) ? $brushesTypes[$item['file-extension']] : 'groovy'); ?>; ruler: true; first-line: <?php echo $item['source-first-line']; ?>; highlight: [<?php echo $item['line']; ?>]"><?php echo implode("\n", $item['source']); ?></pre>
                            <p><?php echo $item['file']; ?></p>
                        <?php else: ?>
                            <p class="preview-not-available">Source code preview is not available.</p>
                            <p>Called method/function: <strong><?php echo $item['file']; ?></strong></p>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <div class="tabs-container">
            <h2>Variables</h2>
            <div class="tabs-list">
                <ul>
                    <li data-tab="var-1"><h4>$_POST</h4></li>
                    <li data-tab="var-2"><h4>$_GET</h4></li>
                    <li data-tab="var-3"><h4>$_FILES</h4></li>
                    <li data-tab="var-4"><h4>$_SERVER</h4></li>
                    <li data-tab="var-5"><h4>$_COOKIE</h4></li>
                    <li data-tab="var-6"><h4>$_SESSION</h4></li>
                </ul>
            </div>
            <div class="tabs-content">
                <div class="tab" id="tab-var-1">
                    <div class="variable-print">
                        <pre><?php print_r($_POST); ?></pre>
                    </div>
                </div>
                <div class="tab" id="tab-var-2">
                    <div class="variable-print">
                        <pre><?php print_r($_GET); ?></pre>
                    </div>
                </div>
                <div class="tab" id="tab-var-3">
                    <div class="variable-print">
                        <pre><?php print_r($_FILES); ?></pre>
                    </div>
                </div>
                <div class="tab" id="tab-var-4">
                    <div class="variable-print">
                        <pre><?php print_r($_SERVER); ?></pre>
                    </div>
                </div>
                <div class="tab" id="tab-var-5">
                    <div class="variable-print">
                        <pre><?php print_r($_COOKIE); ?></pre>
                    </div>
                </div>
                <div class="tab" id="tab-var-6">
                    <div class="variable-print">
                        <pre><?php print_r($_SESSION); ?></pre>
                    </div>
                </div>
            </div>
        </div>

        <footer>
            <div class="generated-at">Generated at <?php echo date('H:i:s m.d.Y'); ?></div>
            Generated by <a href="https://github.com/requtize/eehandler" target="_blank">EEHandler</a> - Error / Exception handler for PHP
        </footer>

        <script>
            SyntaxHighlighter.all();
            $(function() {
                $('.tabs-container').each(function() {
                    var root = $(this);

                    root.find('.tabs-list li').click(function() {
                        root.find('.tabs-list li').removeClass('active');
                        root.find('.tabs-content .tab').removeClass('active');
                        root.find('.tabs-content .tab#tab-' + $(this).data('tab')).addClass('active');
                        $(this).addClass('active');
                    }).first().trigger('click');
                });
            });
        </script>
    </body>
</html>
