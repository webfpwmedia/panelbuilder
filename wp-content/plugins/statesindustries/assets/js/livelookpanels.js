jQuery(document).ready(function($) {

    if ($('#livelook').length == 0) {
        return;
    }

    fetchPanelData();

    if ($('.live-look-controls').length == 0) {
        setInterval(function() {
            fetchPanelData();
        }, 3000);
    }

    $('body').on('change', '#show-panels, #panel-selector', function(e) {
        e.preventDefault();

        if (getLocalShowPanels()) {
            showPanels();
        } else {
            hidePanels();
        }

        showPanelsById(getLocalPanelIds());
        savePanelData();
    });

    function getLocalShowPanels() {
        return $('#show-panels').is(':checked');
    }

    function showPanels() {
        $('.panel-selector-wrapper').show();    
        $('.live-look-wrapper-connected .live-look-panels').show();    
    }

    function hidePanels() {
        $('.panel-selector-wrapper').hide();    
        $('.live-look-wrapper-connected .live-look-panels').hide();   
    }

    function getLocalPanelIds() 
    {
        return $('#panel-selector').val();
    }

    function savePanelData()
    {
        $.ajax({
            url: '/wp-admin/admin-ajax.php',
            data: {
                action: 'save_live_look_data',
                show_panels: getLocalShowPanels(),
                panel_ids: getLocalPanelIds(),
            }
        });
    }

    function fetchPanelData()
    {
        let promise = $.ajax({
            url: '/wp-admin/admin-ajax.php',
            data: {
                action: 'get_live_look_data',
            },
            dataType: 'json',
        });

        promise.done(function (data) {
            if (data.show_panels != 'true') {
                $('#show-panels').prop('checked', false);
                $('#panel-selector').val([]);
                hidePanels();
            } else {
                $('#show-panels').prop('checked', true);
                $('#panel-selector').val(data.panel_ids);
                showPanels();
                showPanelsById(data.panel_ids);
            }
        });
    }

    function showPanelsById(ids) {

        $('.live-look-panels .panel-full').each(function() {
            let panel = $(this);
            let panelId = $(this).data('id').toString();
            
            if (ids.includes(panelId)) {
                $(panel).show();
            } else {
                $(panel).hide();
            }
        });
    }

});