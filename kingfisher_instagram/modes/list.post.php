<?php

    $heading = $Lang->get('Listing posts');

    $form_button = null;

    if($details['settingInstagramToken'] && $details['settingInstagramToken']!='') {
        $form_button = [
                'action' => $Form->action(),
                'button' => $Form->hidden('settingInstagramToken', $details['settingInstagramToken']).$Form->submit('btnSubmit', 'Get posts', 'button button-icon icon-left', true, true, PerchUI::icon('ext/o-cloud-download', 14))
            ];
    }

    echo $HTML->title_panel([
        'heading' => $heading,
        'form' => $form_button,
    ]);

 
    if ($message) {
        echo $message;
        $message = '';  
    } 






    /* ----------------------------------------- SMART BAR ----------------------------------------- */
        $Listing = new PerchAdminListing($CurrentUser, $HTML, $Lang, $Paging);

        $Listing->add_col([
            'title'     => 'Date',
            'value'     => 'postDate',
            'sort'      => 'postDate',
            'format'    => ['type'=>'date', 'format'=>str_replace(' ', '&nbsp;', PERCH_DATE_SHORT.' '.PERCH_TIME_SHORT)],
        ]);

        $Listing->add_col([
          'title'     => 'Post',
          'value'     => function($item) use ($HTML) {
              return $HTML->build('img[src='.$item->postImageThumbnail().'].avatar');
          },
          'sort'      => 'postInstagramID',
      ]);

        $Listing->add_col([
            'title'     => 'Caption',
            'value'     => 'caption',
            'sort'      => 'caption',
        ]);
        echo $Listing->render($posts);

