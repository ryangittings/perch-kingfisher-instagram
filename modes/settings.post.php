<?php
    echo $HTML->title_panel([
        'heading' => $Lang->get('Configuring Instagram')
    ]);
    
    echo $HTML->heading2('Instagram Settings');
    
    echo $message;

    echo $Form->form_start();
    
        echo $Form->text_field('settingInstagramToken', 'Instagram token', $details['settingInstagramToken']);

        $opts = array();
        $opts[] = array('value'=>'0',       'label'=>'Manually');
        $opts[] = array('value'=>'10',      'label'=>'Every 10 minutes');
        $opts[] = array('value'=>'15',      'label'=>'Every 15 minutes');
        $opts[] = array('value'=>'30',      'label'=>'Every 30 minutes');
        $opts[] = array('value'=>'60',      'label'=>'Every hour');
        $opts[] = array('value'=>'120',     'label'=>'Every 2 hours');
        $opts[] = array('value'=>'240',     'label'=>'Every 4 hours');
        $opts[] = array('value'=>'360',     'label'=>'Every 6 hours');
        $opts[] = array('value'=>'720',     'label'=>'Every 12 hours');
        $opts[] = array('value'=>'1440',    'label'=>'Every day');
        $opts[] = array('value'=>'10080',   'label'=>'Every week');
        $opts[] = array('value'=>'40320',   'label'=>'Every month');


        echo $Form->select_field('settingUpdateInterval', 'Check for updates', $opts, $details['settingUpdateInterval']);
        echo $Form->checkbox_field('reauth', 'Force reauthentication', '1', '0');

        echo $Form->submit_field('btnSubmit', 'Save', $API->app_path());

    
    echo $Form->form_end();
