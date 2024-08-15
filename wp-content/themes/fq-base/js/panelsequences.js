class PanelSequences
{
    constructor() {
        this.zoom = 3;
        this.bw = 3;
        this.filterElement = document.querySelectorAll('.panel-sequence-filters-wood-type')[0];

        if (jQuery('.post-type-archive-panel_sequence').length > 0) {
            this.bindFilters()
        }

        if (jQuery('.single-panel_sequence').length > 0) {
            this.setupOpenImage();
            this.setupLoupe();
            this.setupNumberCopy();
        }
    }

    bindFilters() {
        document.querySelectorAll('.sidebar nav .nav-filter').forEach(filter => {
            filter.addEventListener('click', (e) => {
                e.preventDefault();
                this.clearSelectedNavFilters();

                if (e.target.dataset.slug != 'all') {
                    e.target.classList.add('selected');
                }

                this.updatePanels()
            });
        });
    }

    clearSelectedNavFilters() {
        document.querySelectorAll('.sidebar nav .nav-filter').forEach(filter => {
            filter.classList.remove('selected');
        });
    }

    updatePanels() {
        let value = ''; 
        let item = document.querySelector('.sidebar nav .nav-filter.selected');

        if (item) {
            value = item.dataset.slug;
        }

        let promise = jQuery.ajax({
            url: '/wp-admin/admin-ajax.php',
            data: {
                action: 'filter_panel_sequences',
                value: value,
            },
        });

        promise.success(html => {
            document.querySelectorAll('.panel-sequence-container')[0].innerHTML = html;
            this.setupOpenImage();
        });
    }

    setupOpenImage() {
        // Open an image in the large modal loupe
        document.querySelectorAll('.sequences .sequence img').forEach(sequence => {
            sequence.addEventListener('click', () => {
                document.querySelector('.zoom-loupe-container').classList.add('show');
                this.setLoupeImage(sequence);
                this.magnify();
            });
        });
    }

    setupLoupe() {

        // Bind the UI for moving the loupe around
        document.getElementById('loupe').addEventListener('mousemove', (e) => this.moveMagnifier(e));
        document.getElementById('loupe').addEventListener('touchmove', (e) => this.moveMagnifier(e));
        document.getElementById('loupe').addEventListener('mouseover', (e) => this.magnify(e));
        document.getElementById('loupe-image').addEventListener('mousemove', (e) => this.moveMagnifier(e));
        document.getElementById('loupe-image').addEventListener('touchmove', (e) => this.moveMagnifier(e));
        document.getElementById('loupe-image').addEventListener('mouseover', (e) => this.magnify(e));
        
        // Close the loupe either by hitting the close button or using the escape key.
        document.getElementById('close').addEventListener('click', (e) => this.hideMagnifier(e));

        // Keyboard navigation
        document.onkeydown = (evt) => {
            evt = evt || window.event;
            var isEscape = false;
            if ("key" in evt) {
                isEscape = (evt.key === "Escape" || evt.key === "Esc");
            } else {
                isEscape = (evt.keyCode === 27);
            }
            if (isEscape) {
                this.hideMagnifier();
            }
        };
    }

    setupNumberCopy() {
        // Setup the copy button for copying the number to the clipboard.
        document.querySelectorAll('.copy-sequence-number').forEach(sequenceBtn => {
            sequenceBtn.addEventListener('click', (e) => {
                e.preventDefault();
                let input = document.createElement('input');
                document.body.appendChild(input);
                input.value = sequenceBtn.dataset.number;
                input.select();
                input.setSelectionRange(0, 9999);
                document.execCommand('copy');
                sequenceBtn.querySelector('.text').innerHTML = 'Copied!';

                setTimeout(() => {
                    sequenceBtn.querySelector('.text').innerHTML = 'Click to Copy';
                }, 3000);
            });
        });
    }

    moveMagnifier(e) {

        let glass, img, pos, x, y, w, h;
        img = document.getElementById('loupe-image');
        glass = document.getElementById('loupe');
        w = glass.offsetWidth / 2;
        h = glass.offsetHeight / 2;

        /* Prevent any other actions that may occur when moving over the image */
        e.preventDefault();

        /* Get the cursor's x and y positions: */
        pos = this.getCursorPos(e, img);
        x = pos.x;
        y = pos.y;

        /* Prevent the magnifier glass from being positioned outside the image: */
        if (x > img.width - (w / this.zoom)) {x = img.width - (w / this.zoom);}
        if (x < w / this.zoom) {x = w / this.zoom;}
        if (y > img.height - (h / this.zoom)) {y = img.height - (h / this.zoom);}
        if (y < h / this.zoom) {y = h / this.zoom;}

        /* Set the position of the magnifier glass: */
        glass.style.left = (x - w + img.offsetLeft) + "px";
        glass.style.top = (y - h + img.offsetTop) + "px";

        /* Display what the magnifier glass "sees": */
        glass.style.backgroundPosition = "-" + ((x * this.zoom) - w + this.bw) + "px -" + ((y * this.zoom) - h + this.bw) + "px";
    }

    setLoupeImage(sequence) {
        let src = sequence.src;
        let index = sequence.parentElement.dataset.index;
        document.querySelector('.zoom-loupe-container').dataset.current = index;
        document.getElementById('loupe-image').src = src;
    }

    getCursorPos(e, img) {
        let a, x = 0, y = 0;
        e = e || window.event;

        /* Get the x and y positions of the image: */
        a = img.getBoundingClientRect();

        /* Calculate the cursor's x and y coordinates, relative to the image: */
        x = e.pageX - a.left;
        y = e.pageY - a.top;

        /* Consider any page scrolling: */
        x = x - window.pageXOffset;
        y = y - window.pageYOffset;

        return {x : x, y : y};
    }

    magnify() {
        let glass, img, w, h;
        img = document.getElementById('loupe-image');
        glass = document.getElementById('loupe');

        /* Set background properties for the magnifier glass: */
        glass.style.backgroundImage = "url('" + img.src + "')";
        glass.style.backgroundRepeat = "no-repeat";
        glass.style.backgroundSize = (img.width * this.zoom) + "px " + (img.height * this.zoom) + "px";
        w = glass.offsetWidth / 2;
        h = glass.offsetHeight / 2;
    }

    hideMagnifier() {
        document.querySelector('.zoom-loupe-container').classList.remove('show');
    }
}


new PanelSequences;
