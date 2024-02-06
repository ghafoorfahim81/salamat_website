<modal
    v-if="isFilterModalOpen"
    @close-modal="closeFilterModal"
    :title="`{{__('document.add_copies')}}`"
    :loading="save_tracker_loader"
    :disabled="false"
    :loading_text="'something'"
    :btn_name="'{{__('document.add_copies')}}'"
    :show-submit="true"
    :btn_icon="'cloud_upload'"
    @submit="closeFilterModal"
    :cancel_text="`{{__('general_words.cancel')}}`"


>
    <!-- Content to display in the modal -->

    <form>

        <div class="grid grid-cols-12 gap-6 mt-2 p-1">
            <div class="relative col-span-4">
                <input id="include-directorate-radio" type="radio" value="directorate" @input="ccTypeChange('directorate')" v-model="selected_ccType"
                       class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                <label for="include-directorate-radio"
                       class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">{{__('document.include_directorate')}}</label>
            </div>

            <div class="relative col-span-4">
                <input id="include-employees-radio" type="radio" value="employee" v-model="selected_ccType"
                       @input="ccTypeChange('employee')"
                       class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                <label for="include-employees-radio" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">{{__('document.include_employees')}}</label>
            </div>

        </div>

        <div class="grid grid-cols-12 gap-6 mt-2 p-1">

            <div class="relative col-span-6">
                <v-select :options="mDirectorates" class="text-sm" id="receiver" label="name"
                          @input="directorateChange"
                          v-model="m_selected_directorate"></v-select>
                <floating-label :id="'selected_directorate'" :label="'{{__('document.directorate')}}'"/>
            </div>
            <div class="relative col-span-6" v-show="selected_ccType=='employee'">
                <v-select :options="mEmployees" class="text-sm" id="receiver" label="name"
                          @input="addToEmpArray(m_selected_employee)" v-model="m_selected_employee"></v-select>
                <floating-label :id="'selected_directorate'" :label="'{{__('document.employee')}}'"/>
            </div>
        </div>
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg mt-2">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-4 py-3" v-show="selected_ccType=='employee'">
                        {{__('document.employee_name')}}
                    </th>
                    <th scope="col" class="px-4 py-3" v-show="selected_ccType=='employee'">
                        {{__('document.father_name')}}
                    </th>
                    <th scope="col" class="px-4 py-3" v-show="selected_ccType=='employee'">
                        {{__('document.position')}}
                    </th>
                    <th scope="col" class="px-4 py-3" v-show="selected_ccType=='directorate'">
                        {{__('document.directorate_name')}}
                    </th>
                    <th scope="col" class="px-4 py-3">
                        {{__('general_words.action')}}
                    </th>
                </tr>
                </thead>
                <tbody>
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600"
                    v-for="(emp, index) in selected_employees" v-if="selected_ccType=='employee'">
                    <td class="px-1 py-1 px-2">
                        @{{ emp.name }}
                    </td>
                    <td class="px-1 py-1">
                        @{{ emp.father_name }}
                    </td>
                    <td class="px-1 py-1">
                        @{{ emp.position }}
                    </td>
                    <td class="flex items-center px-4 py-4">
                        <a @click="deleteFromEmpArray(index)" class="hover:cursor-pointer">
                            <i class="material-icons text-red-600 dark:text-red-500">
                                delete
                            </i>
                        </a>
                    </td>
                </tr>
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600"
                    v-for="(dir, index) in selected_directorates" v-if="selected_ccType=='directorate'">
                    <td class="px-1 py-1 px-2">
                        @{{ dir.name }}
                    </td>
                    <td class="flex items-center px-4 py-4">
                        <a @click="deleteFromDirArray(index)" class="hover:cursor-pointer">
                            <i class="material-icons text-red-600 dark:text-red-500">
                                delete
                            </i>
                        </a>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>

    </form>

</modal>
