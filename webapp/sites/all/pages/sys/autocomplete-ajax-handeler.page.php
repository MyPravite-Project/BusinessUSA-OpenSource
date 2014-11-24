<?php
    // Destroy the markup of the BUSA Logo, Main Menu, etc, from the output-buffer
    @ob_end_clean();
    while (@ob_end_clean());
    
    $matches = get_autocomplete_results(); // Note: get_autocomplete_results() is defined in autocomplete_functions.php
    $content_types = $matches['content_types'];
    $title_results = $matches['title_results'];
    $agency_results = $matches['agency_results'];
    $wizard_results = $matches['wizard_results'];
    
    // If there are no rsults, then dont bother rendering any HTML
    $total_results = count($title_results) + count($agency_results) + count($wizard_results);
    if ( $total_results == 0 ) {
        exit();
    }
    
?>

<!-- The following markup is generated by sys-autocomplete-ajax-handeler.tpl.php -->
<div class="autocomplete-ajax-responce" rendersource="sys-autocomplete-ajax-handeler.tpl.php">

    <?php
    
        // Define what icons to user for each content-type
        $cont_type_images = array(
            'program' => '/sites/all/themes/bizusa/images/content-types-icons/20X20/program.png',
            'services' => '/sites/all/themes/bizusa/images/content-types-icons/20X20/service.png',
            'tools' => '/sites/all/themes/bizusa/images/content-types-icons/20X20/tools.png',
            'event' => '/sites/all/themes/bizusa/images/content-types-icons/20X20/event.png',
            'article' => '/sites/all/themes/bizusa/images/content-types-icons/20X20/article.png',
            'appointment_office' => '/sites/all/themes/bizusa/images/content-types-icons/20X20/resource_center.png',
            'agency' => '/sites/all/themes/bizusa/images/content-types-icons/20X20/agency.png',
            'wizard' => '/sites/all/themes/bizusa/images/content-types-icons/20X20/wizard.png'
        );
    ?>
    
    <div class="debuginfo-autocomplete_results" style="display: none;">
        <!--
                [!!] DEBUG INFO [!!] 
                /* Coder Bookmark: CB-EVCJM7Y-BC */
                $matches = <?php print_r($matches); ?>
        -->
    </div>

    <?php if ( count($wizard_results) > 0 ) { ?>

        <!-- Start of the Auto-complete section for Wizards. Coder Bookmark: CB-DU1IF8E-BC -->
        <li class="auto-suggestion-debug debug-info-autocompleteresults" style="display: none;">
            <!-- 
                [!!] DEBUG INFO [!!] 
                /* Coder Bookmark: CB-C4PGBB4-BC */
                $wizard_results = <?php print_r($wizard_results); ?>
            -->
        </li>
    
        <li class="auto-suggestion-header">
            <div class="autocomplete-subttl">
                Wizards
            </div>

            <img class="auto-suggestion-image" alt="Icon for Wizards auto suggestions" src="<?php print $cont_type_images['wizard']; ?>">

        </li>
          
        <?php foreach ( $wizard_results as $key => $wizardTitle ) { /* Foreach wizard result */ ?>
        
            <?php 
                // HTML-decode the wizard's title
                $wizardTitleDecoded = html_entity_decode(utf8_decode($wizardTitle)); 
                // Override the anchor target for "Grow Your Business"
                if ( $wizardTitle == 'Grow Your Business' ) { 
                    $key = "resource/growing-your-business";
                }
            ?>
            
            <li class="autocomplete-result">
                <a href="/<?php print $key; ?>">
                    <?php print $wizardTitle; ?>
                </a>
            </li>

        <?php } /* end foreach */ ?>
       
    <?php } /* end if */ ?>

    
    <?php foreach ( $content_types as $contentTypeMacName => $contentTypeName) { ?>
        <?php if ( count($title_results[$contentTypeMacName]) > 0 ) { ?>
            <ul>
            <!-- Start of the Auto-complete section for results of this content-type ($contentTypeName). Coder Bookmark: CB-CBA0HEY-BC -->
            <li class="auto-suggestion-debug debug-info-autocompleteresults" style="display: none;">
                <!-- 
                    [!!] DEBUG INFO [!!] 
                    /* Coder Bookmark: CB-4GIJ3KE-BC */
                    $contentTypeMacName = <?php print $contentTypeMacName; ?>
                    $title_results[$contentTypeMacName] = <?php print_r( $title_results[$contentTypeMacName] ); ?>
                -->
            </li>
            
            <li class="auto-suggestion-header">
                <div class="autocomplete-subttl">
                    <?php print $contentTypeName; ?>
                </div>

                <img class="auto-suggestion-image" alt="Icon for <?php print $contentTypeName; ?> auto suggestions" src="<?php print $cont_type_images[$contentTypeMacName]; ?> ">

            </li>

            <?php foreach( $title_results[$contentTypeMacName] as $resultTitle ) { ?>
                <?php $resultTitleDecoded = html_entity_decode(utf8_decode($resultTitle)); ?>
                <li class="autocomplete-result">
                    <a href="/search/site/<?php print $resultTitle; ?>?f[0]=bundle:<?php print $contentTypeMacName; ?>&auto=1">
                        <?php print $resultTitleDecoded; ?>
                    </a>
                </li>
            <?php } ?>
</ul>
        <?php } /* end if */ ?>
    <?php } /* end foreach */ ?>
    
    <?php if ( count($agency_results) > 0 ) { ?>
    
        <!-- Start of the Auto-complete section for Agencies. Coder Bookmark: CB-W8HKJ5H-BC -->
        <li class="auto-suggestion-debug debug-info-autocompleteresults" style="display: none;">
            <!-- 
                [!!] DEBUG INFO [!!] 
                /* Coder Bookmark: CB-56N3679-BC */
                $agency_results = <?php print_r($agency_results); ?>
            -->
        </li>
        
        <li class="auto-suggestion-header">
            <div class="autocomplete-subttl">
                Agencies
            </div>

            <img class="auto-suggestion-image" alt="Icon for Agencies auto suggestions" src="<?php print $cont_type_images['agency']; ?>" />

        </li>
        
        <?php foreach ( $agency_results as $key => $agency ) { /* Print a <li> for each result in the $agency_results array */ ?>
            <?php $agencyDecoded = html_entity_decode( utf8_decode($agency) ); ?>
            <li class="autocomplete-result">
                <a href="/search/site/<?php print $agency; ?>?f[0]=ts_joined_agency:<?php print $agency; ?>&auto=1" >
                    <?php print $agencyDecoded; ?>
                </a>
            </li>
        <?php } /* end foreach */ ?>
        
    <?php } /* end if */ ?>

    </ul>
</div>

<?php
    // We do not want to print any more data to the web-socket, terminate this PHP thread.
    exit();
?>