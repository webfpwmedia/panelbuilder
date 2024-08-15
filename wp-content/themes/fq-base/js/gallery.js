const galleryElementClass = 'blocks-gallery-item';
const modalId = 'gallery-modal';
const modalClass = modalId;

class Gallery {

    constructor() {
        this.initModal();
        
        let galleryItems = document.getElementsByClassName( galleryElementClass );

        if (galleryItems.length > 0) {
            [...galleryItems].forEach(galleryItem => {
                if (galleryItem.querySelectorAll('a') != null) {
                    galleryItem.addEventListener('click', (event) => {
                        this.openGalleryItemInModel(event);
                    });
                }
            });
        };
    }

    initModal() {
        let modalElement = document.createElement('div');
        modalElement.setAttribute('id', modalId);
        modalElement.classList.add(modalClass);
        modalElement.innerHTML = '<div class="bg"></div><div class="content"><button class="close"><i class="far fa-times"></i></button><div class="inner"></div></div>';

        document.body.appendChild(modalElement);

        document.getElementById(modalId).querySelector('.bg').addEventListener('click', (event) => {
            this.closeModal();
        });

        document.getElementById(modalId).querySelector('.close').addEventListener('click', (event) => {
            event.preventDefault();
            this.closeModal();
        });
    }

    closeModal() {
        document.getElementById(modalId).classList.remove('show');   
    }

    openGalleryItemInModel(event) {
        event.preventDefault();
        let image = event.target;
        let caption = image.parentElement.parentElement.querySelector('.blocks-gallery-item__caption');
        let modal = document.getElementById(modalId);
        let modalContent = modal.querySelector('.content .inner');
        modalContent.innerHTML = '';
        modalContent.appendChild(image.cloneNode(true));

        if (caption) {
            let captionElement = document.createElement('p');
            captionElement.innerText = caption.innerText;
            modalContent.appendChild(captionElement);
        }

        modal.classList.add('show');
    }
}

new Gallery;

