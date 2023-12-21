<script defer type="module">
    Vue.component('modal-upload', {
        props: ['name'],
        template: '#modal-upload-template',
        data() {
            return {
                files: [],
                multiple: true
                // isMultiple: this.multiple ?? false,
            }
        },
        methods: {
            removeFile(file) {
                this.files = this.files.filter(f => f !== file);
            },
            close() {
                this.$root.closeModal('upload-modal')
            },
                getSrc(file) {
                return URL.createObjectURL(file);
            },
            selectFiles(event) {
                if(!this.multiple)
                    this.files = [];

                for (let i = 0; i < event.target.files.length; i++) {
                    const file = event.target.files[i];
                    this.files.push(file);
                }
            },
            getStatus() {

            },
            async uploadFile(file, index) {
                const ref = this.$refs['resourceItem_' + index][0] ?? null;

                const formData = new FormData();
                formData.append('file', file);
                formData.append('alternativeText', ref.localAlternativeText);

                return new Promise((resolve, reject) => {
                    const xhr = new XMLHttpRequest();

                    xhr.upload.onprogress = function (event) {
                        if (event.lengthComputable) {
                            const percentComplete = (event.loaded / event.total) * 100;
                            file.upload_progression = percentComplete;
                            ref.updateProgression(percentComplete);
                        }
                    };

                    xhr.onload = function () {
                        if (xhr.status === 200) {
                            // sleep
                            resolve(JSON.parse(xhr.response));
                        } else {
                            reject('Error uploading file: ' + xhr.status);
                        }
                    };

                    xhr.onerror = function () {
                        reject('Network error while uploading file');
                    };

                    xhr.open('POST', DODOCMS_APPLICATION.toApi("/resources/upload"), true);
                    xhr.send(formData);
                })
            },
            async startUpload() {
                this.$emit('upload-start', this.files);

                let uploadedFiles = [];
                let resourcesFiles = [];
                try {
                    for (let index = 0; index < this.files.length; index++) {
                        const file = this.files[index];
                        const resource = await this.uploadFile(file, index);
                        this.$root.$emit('resourceUploaded', resource.data);
                        uploadedFiles.push(file);
                        resourcesFiles.push(resource.data);
                    }
                    console.log(this.$root)
                    this.$root.$emit('resources-uploaded', resourcesFiles);
                } catch (error) {
                    console.error('Upload failed:', error);
                } finally {
                    const files = [...this.files];
                    for (let index = 0; index < files.length; index++) {
                        const file = files[index];
                        this.removeFile(file);
                    }

                    if (this.files.length === 0) {
                        this.close();
                        this.$emit('upload-finish', uploadedFiles)
                    }
                }
            }
        }
    });
</script>
<script type="text/x-template" id="modal-upload-template">
    <modal name="upload-modal">
        <template v-slot:title>
            <i class='fa-solid fa-cloud-upload dodocms-me-1'></i> Upload a new resources
        </template>
        <template v-slot:body>
            <div class="dodocms-flex dodocms-items-center dodocms-justify-center dodocms-w-full">
                <label for="dropzone-file"
                       class="dodocms-relative dodocms-flex dodocms-flex-col dodocms-items-center dodocms-justify-center dodocms-w-full dodocms-h-64 dodocms-border-2 dodocms-border-gray-300 dodocms-border-dashed dodocms-rounded-lg cursor-pointer dodocms-bg-gray-50 dark:hover:dodocms-bg-bray-800 dark:dodocms-bg-gray-700 hover:dodocms-bg-gray-100 dark:dodocms-border-gray-600 dark:hover:dodocms-border-gray-500 dark:hover:dodocms-bg-gray-600">
                    <div class="dodocms-flex dodocms-flex-col dodocms-items-center dodocms-justify-center pt-5 pb-6">
                        <svg class="dodocms-w-8 dodocms-h-8 dodocms-mb-4 dodocms-text-gray-500 dark:dodocms-text-gray-400"
                             aria-hidden="true"
                             xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                  stroke-width="2"
                                  d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"/>
                        </svg>
                        <p class="dodocms-mb-2 dodocms-text-sm dodocms-text-gray-500 dark:dodocms-text-gray-400"><span
                                    class="dodocms-font-semibold"><?= __("admin.panel.resources.upload.click_to_upload") ?></span>
                            <?= __("admin.panel.resources.upload.drag_and_drop") ?></p>
                        <p class="dodocms-text-xs dodocms-text-gray-500 dark:dodocms-text-gray-400">PDF, JPEG, PNG or
                            JPG</p>
                    </div>
                    <input @change="selectFiles" :multiple="multiple" name="files[]" id="dropzone-file" type="file"
                           class="dodocms-absolute dodocms-w-full dodocms-h-full dodocms-opacity-0"/>
                </label>
            </div>
            <div v-if="files.length > 0"
                 class="dodocms-py-3 dodocms-pe-3 dodocms-grid dodocms-grid-cols-3 dodocms-gap-4"
                 style="max-height: 300px; overflow-y: auto;">
                <resource-item v-for="(file, index) in files"
                               :ref="`resourceItem_${index}`"
                               :key="index"
                               :editable="true"
                               :deletable="true"
                               :src="getSrc(file)"
                               :alternativeText="''"
                               @delete="removeFile(file)"
                >
                </resource-item>
            </div>
        </template>
        <template v-slot:footer>
            <button type="button"
                    v-on:click="close"
                    class="close-upload-modal dodocms-me-auto dodocms-text-gray-500 dodocms-bg-white hover:dodocms-bg-gray-100 focus:ring-4 focus:dodocms-outline-none focus:ring-blue-300 dodocms-rounded-lg dodocms-border dodocms-border-gray-200 dodocms-text-sm dodocms-font-medium dodocms-px-5 dodocms-py-2.5 hover:dodocms-text-gray-900 focus:dodocms-z-10 dark:dodocms-bg-gray-700 dark:dodocms-text-gray-300 dark:dodocms-border-gray-500 dark:hover:dodocms-text-white dark:hover:dodocms-bg-gray-600 dark:focus:ring-gray-600">
                <?= __("admin.panel.resources.upload.close") ?>
            </button>
            <div class="dodocms-me-auto dodocms-text-white dodocms-opacity-75" id="state">
            </div>
            <button v-on:click="startUpload"
                    class="dodocms-text-white dodocms-bg-blue-700 hover:dodocms-bg-blue-800 focus:ring-4 focus:dodocms-outline-none focus:ring-blue-300 dodocms-font-medium dodocms-rounded-lg dodocms-text-sm dodocms-px-5 dodocms-py-2.5 dodocms-text-center dark:dodocms-bg-blue-600 dark:hover:dodocms-bg-blue-700 dark:focus:ring-blue-800">
                <?= __("admin.panel.resources.upload.submit") ?>
            </button>
        </template>
    </modal>
</script>