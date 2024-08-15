class SwatchLibrary
{
    constructor() {
        this.familyFilter = document.querySelectorAll('.swatch-filters-family')[0];
        this.bindFilters();
    }

    bindFilters() {
        this.familyFilter.addEventListener('change', this.updatelibrary.bind(this));
    }

    updatelibrary() {
        let promise = jQuery.ajax({
            url: '/wp-admin/admin-ajax.php',
            data: {
                action: 'filter_swatch_library',
                family: this.familyFilter.value,
            },
        });

        promise.success(html => {
            document.querySelectorAll('.swatch-container')[0].innerHTML = html;

            if (html == '') {
                document.getElementById('swatch-no-results').classList.add('show');
            } else {
                document.getElementById('swatch-no-results').classList.remove('show');
            }
        });
    }
}

if (jQuery('.swatch-container').length > 0) {
    new SwatchLibrary;
}