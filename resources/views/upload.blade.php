<x-app-layout>
    <x-slot name="header">

        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            QR File: upload
        </h2>

    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <form method="post" action="{{ route('fileupload') }}" enctype="multipart/form-data" class="dropzone"
                        id="dropzone">
                        @csrf
                        <div class="dz-default dz-message">
                            <h4>Drop files here or click to upload</h4>
                        </div>
                    </form>

                    <p class="message"></p>
                    <br>
                    <ul>
                        <li>Max File size 1MB</li>
                        <li>PDF extension file allowed</li>
                        <li></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        Dropzone.options.dropzone = {
            maxFiles: 10,
            maxFilesize: 1,

            acceptedFiles: ".pdf",
            // addRemoveLinks: true,
            timeout: 5000,

            success: function(file, response) {
                console.log(response.success);
                $('.message').html('File ' + response.success +
                    ' was submitted');
                return file.previewElement.classList.add("dz-success"),
                    $(function() {
                        setTimeout(function() {
                            $('.dz-success').fadeOut('slow');
                        }, 2500);
                    });

            },
            error: function(file, response) {
                console.log(response);
                $('.message').html('Something went wrong');

                return false;
            }
        };
    </script>

</x-app-layout>
