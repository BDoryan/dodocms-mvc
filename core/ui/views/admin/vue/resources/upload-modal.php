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
                if (!this.multiple)
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

                    xhr.open('POST', window.toApi("/resources/upload"), true);
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
            <i class='fa-solid fa-cloud-upload tw-me-1'></i> <?= __("admin.panel.resources.upload.title") ?>
        </template>
        <template v-slot:body>
            <div class="tw-flex tw-items-center tw-justify-center tw-w-full">
                <label for="dropzone-file"
                       class="tw-relative tw-flex tw-flex-col tw-items-center tw-justify-center tw-w-full tw-h-64 tw-border-2 tw-border-dashed tw-rounded-lg cursor-pointer hover:tw-bg-bray-800 tw-bg-gray-300 tw-bg-opacity-50 tw-border-gray-300 hover:tw-bg-opacity-70 hover:tw-border-gray-400 hover:tw-border-opacity-70">
                    <div class="tw-flex tw-flex-col tw-items-center tw-justify-center pt-5 pb-6">
                        <svg class="tw-w-8 tw-h-8 tw-mb-4 tw-text-gray-500 dark:tw-text-gray-400"
                             aria-hidden="true"
                             xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                  stroke-width="2"
                                  d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"/>
                        </svg>
                        <p class="tw-mb-2 tw-text-sm tw-text-gray-500 dark:tw-text-gray-400"><span
                                    class="tw-font-semibold"><?= __("admin.panel.resources.upload.click_to_upload") ?></span>
                            <?= __("admin.panel.resources.upload.drag_and_drop") ?></p>
                        <p class="tw-text-xs tw-text-gray-500 dark:tw-text-gray-400">PDF, JPEG, PNG or
                            JPG</p>
                    </div>
                    <input @change="selectFiles" :multiple="multiple" name="files[]" id="dropzone-file" type="file"
                           class="tw-absolute tw-w-full tw-h-full tw-opacity-0"/>
                </label>
            </div>
            <div v-if="files.length > 0"
                 class="tw-py-3 tw-pe-3 tw-grid tw-grid-cols-3 tw-gap-4"
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
                    class="close-upload-modal tw-me-auto tw-text-gray-500 tw-bg-white hover:tw-bg-gray-100 focus:ring-4 focus:tw-outline-none focus:ring-blue-300 tw-rounded-lg tw-border tw-border-gray-200 tw-text-sm tw-font-medium tw-px-5 tw-py-2.5 hover:tw-text-gray-900 focus:tw-z-10 dark:tw-bg-gray-700 dark:tw-text-gray-300 dark:tw-border-gray-500 dark:hover:tw-text-white dark:hover:tw-bg-gray-600 dark:focus:ring-gray-600">
                <?= __("admin.panel.resources.upload.close") ?>
            </button>
            <div class="tw-me-auto tw-text-white tw-opacity-75" id="state">
            </div>
            <button v-on:click="startUpload"
                    class="tw-text-white tw-bg-blue-700 hover:tw-bg-blue-800 focus:ring-4 focus:tw-outline-none focus:ring-blue-300 tw-font-medium tw-rounded-lg tw-text-sm tw-px-5 tw-py-2.5 tw-text-center dark:tw-bg-blue-600 dark:hover:tw-bg-blue-700 dark:focus:ring-blue-800">
                <?= __("admin.panel.resources.upload.submit") ?>
            </button>
        </template>
    </modal>
</script>