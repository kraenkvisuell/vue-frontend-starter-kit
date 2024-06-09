<template>
    <form>
        <div class="flex items-center gap-4">
            <div>
                <button
                    class="button btn-primary p-0"
                    :disabled="isUploading"
                >
                    <input
                        id="skuImportFile"
                        class="absolute w-full h-full opacity-0 cursor-pointer"
                        @change="upload"
                        type="file"
                        accept=".xls,.xlsx"
                    />

                    <span class="px-8">Datei hochladen</span>
                </button>
            </div>

            <div>
                <span class="italic" v-if="isUploading">
                    Datei wird hochgeladen...
                </span>

                <span class="text-red-500" v-if="hasErrors">
                    {{ errorMessage }}
                </span>

                <span class="text-green-500" v-if="successMessage">
                    {{ successMessage }}
                </span>
            </div>
        </div>
    </form>
</template>

<script>

import axios from 'axios'

export default {
    data() {
        return {
            isUploading: false,
            hasErrors: false,
            errorMessage: '',
            successMessage: '',
            file: null,
        }
    },

    props: {
        uploadroute: String,
    },

    methods: {
        upload(e) {
            this.isUploading = true
            this.hasErrors = false
            this.errorMessage = ''
            this.successMessage = ''
            this.$progress.start('uploading')

            let formData = new FormData();
            formData.append('file', e.target.files[0]);
            axios.post(this.uploadroute, formData, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            }).then((response) => {
                this.isUploading = false

                if (response.data.hasErrors) {
                    this.hasErrors = true
                    this.errorMessage = response.data.errorMessage
                } else {
                    this.successMessage = response.data.rowCount + ' Artikel wurden hochgeladen.'
                }

                this.$progress.complete('uploading')

                document.querySelector('#skuImportFile').value = null
            }).catch((error) => {
                console.log(error)
            })
        },
    },

    mounted() {

    }
};
</script>
