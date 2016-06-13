/**
 * Advert js functional.
 */

/* global TWIG, qq */

$(document).ready(function () {
    var uploader = new qq.FineUploader({
        template: 'qq-template-s3',
        element: document.getElementById('advert_unmanagedDocuments_uploader'),
        deleteFile: {
            enabled: true,
            endpoint: TWIG.FineUploader.deleteFileEndpoint
        },
        request: {
            endpoint: TWIG.FineUploader.requestEndpoint
        },
        callbacks: {
            onComplete: function (id, name, response) {
                var fileItem = this.getItemByFileId(id);
                if (response.success) {
                    $(qq(fileItem).getByClass('advert-unmanagedDocument-uuid')[0])
                            .attr({
                                id: TWIG.Form.unmanagedDocumentsId + '___name___uuid'.replace('__name__', id),
                                name: TWIG.Form.unmanagedDocumentsFullName + '[__name__][uuid]'.replace('__name__', id),
                                value: this.getUuid(id)
                            });
                }
            },
            onDelete: function (id) {
                $('#' + TWIG.Form.coordsunmanagedDocumentsId + ' input[value="' + this.getUuid(id) + '"][type="hidden"]').closest('.form-group').remove();
            }
        }
    });

    if (TWIG.FineUploader.initialFiles !== undefined) {
        uploader.addInitialFiles(TWIG.FineUploader.initialFiles);
    }

    $('#address_map').locationpicker({
        location: {
            latitude: 49.84478853877884,
            longitude: 24.0261287689209
        },
        radius: 10,
        enableAutocomplete: true,
        scrollwheel: false,
        inputBinding: {
            latitudeInput: $('#' + TWIG.Form.coordsLatId),
            longitudeInput: $('#' + TWIG.Form.coordsLongId),
            locationNameInput: $('#' + TWIG.Form.addressId)
        }
    });
});
