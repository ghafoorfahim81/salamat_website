<div class="grid gap-4 mb-4 md:grid-cols-4">
    <div class="relative">
        <v-select :options="docTypes" v-model="selected_doc_type" label="name"
        ></v-select>
        <floating-label :id="''" :label="`{{__('document.in_out')}}`"/>
    </div>
    <div class="relative">
        <v-select class="" :options="documentTypes" v-model="selected_type" label="name"
        ></v-select>
        <floating-label :id="''" :label="`{{__('document.document_type')}}`"/>
    </div>
    <div>
        <date-picker ref="date" locale="da" clearable placeholder="{{__('report.from_date')}}"
                     :locale-config="localeConfigs" :column="1" mode="single"
                     v-model="generalReportProperties.from_date">

        </date-picker>

    </div>
    <div>
        <date-picker ref="date" locale="da" clearable placeholder="{{__('report.from_date')}}"
                     :locale-config="localeConfigs" :column="1" mode="single" v-model="generalReportProperties.to_date">

        </date-picker>
    </div>

    <div class="relative">
        <v-select :options="directorates"
                  @input="filterEmployeeByDirectorate(selected_sender_directorate?.id)"
                  label="name" v-model="selected_sender_directorate"></v-select>
        <floating-label :id="'selected_directorate'" :label="`{{__('document.sender')}}`"/>
    </div>
    <div class="relative">
        <v-select :options="directorates"
                  @input="filterEmployeeByDirectorate(selected_receiver_directorate?.id)"
                  label="name" v-model="selected_receiver_directorate"></v-select>
        <floating-label :id="'selected_directorate'" :label="`{{__('document.receiver')}}`"/>
    </div>
    <div class="relative">
        <v-select :options="employees"
                  label="name" v-model="selected_sender_employee"
        ></v-select>
        <floating-label :id="'selected_sender_employee'" :label="`{{__('report.sender_employee')}}`"/>
    </div>
    <div class="relative">
        <v-select :options="employees"
                  label="name" v-model="selected_receiver_employee"
        ></v-select>
        <floating-label :id="'selected_directorate'" :label="`{{__('report.receiver_employee')}}`"/>
    </div>
    <div class="relative">
        <v-select :options="inOut" v-model="selected_in_out" label="name"
        ></v-select>
        <floating-label :id="''" :label="`{{__('document.sadera_wareda')}}`"/>
    </div>
    <div>
        <d-input type="text" :label="`{{__('document.focal_point')}}`"
                 :name.sync="generalReportProperties.focal_point_name"/>
    </div>
</div>
<div class="flex items-center space-x-2 rounded-b dark:border-gray-600 right-10">
    <div>
        <search-btn @click="getGeneralReportData" :btn_name="`{{__('general_words.search')}}`"/>
    </div>
    <div>
        <cancel-btn @click="resetForm" :btn_name="`{{__('general_words.cancel')}}`"/>
    </div>
    <div class="relative flex justify-end flex-grow">
        <excel-btn :label="`{{__('general_words.download')}}`" :loading="directorate_download_loading"
                   @download="exportGeneralReport"/>
    </div>
</div>
<div class="mt-3">
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <table
            class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead
                class="text-xs text-gray-600 uppercase bg-gray-300 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-3 py-3 text-center">
                    @lang('report.title')
                </th>
                <th scope="col" class="px-3 py-3 text-center">
                    @lang('document.internal_external')
                </th>
                <th scope="col" class="px-3 py-3 text-center">
                    @lang('report.document_type')
                </th>
                <th scope="col" class="px-3 py-3 text-center">
                    @lang('document.sender')
                </th>
                <th scope="col" class="px-3 py-3 text-center">
                    @lang('document.receiver')
                </th>
                <th scope="col" class="px-3 py-3 text-center">
                    @lang('document.in_number')
                </th>
                <th scope="col" class="px-3 py-3 text-center">
                    @lang('document.out_number')
                </th>
                <th scope="col" class="px-3 py-3 text-center">
                    @lang('document.in_date')
                </th>
                <th scope="col" class="px-3 py-3 text-center">
                    @lang('document.document_status')
                </th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td v-show="!loading && generalReportsData.length < 1" class="text-center" colspan="8">
                    <div style="height: 30px;">
                        <span class="text-md">{{__('general_words.no_record_found')}}</span>
                    </div>
                </td>
            </tr>
            <template v-for="show in 4" v-show="loading">
                <tr>
                    <td v-for="showTd in 10">
                        <skeleton :show="loading"/>
                    </td>
                </tr>
            </template>
            <tr v-for="data in generalReportsData" v-show="generalReportsData.length>0 && !loading"
                class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                <td class="px-3 py-2 text-center" v-if=>
                    @{{ data.title }}
                </td>
                <td class="px-3 py-2 text-center">
                    @{{ data.type }}
                </td>
                <td class="px-3 py-2 text-center">
                    @{{ data.docTypeName }}
                </td>
                <td class="px-3 py-2 text-center">
                    @{{ data.sender }}
                </td>
                <td class="px-3 py-2 text-center">
                    @{{ data.receiver }}
                </td>
                <td class="px-3 py-2 text-center">
                    @{{ data.in_num }}
                </td>
                <td class="px-3 py-2 text-center">
                    @{{ data.out_num }}
                </td>
                <td class="px-3 py-2 text-center">
                    @{{ data.in_date }}
                </td>
                <td class="px-3 py-2 text-center">
                    @{{ data.status }}
                </td>
            </tr>
            </tbody>
        </table>
    </div>

</div>
