
<div class="flex flex-wrap">
    <div class="relative flex justify-start w-1/3">
        <v-select :options="directorates" class="text-sm text-width w-full" label="name"
                  @input="getDirectorateReportData"
                  v-model="selected_directorate"></v-select>
        <floating-label :id="'deputy'" :label="`{{__('document.directorate')}}`"/>
    </div>
    <div class="relative flex justify-end flex-grow">
        <excel-btn :label="`{{__('general_words.download')}}`" :loading="directorate_download_loading" @download="exportDirectorateReport"/>
    </div>
</div>


<div class="mt-3">
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <table
            class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead
                class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-3 py-3 text-center">
                    @lang('report.sender_directorate')
                </th>
                <th scope="col" class="px-3 py-3 text-center">
                    @lang('report.document_type')
                </th>
                <th scope="col" class="px-3 py-3 text-center">
                    @lang('report.total')
                </th>
                <th scope="col" class="px-3 py-3 text-center">
                    @lang('report.received')
                </th>
                <th scope="col" class="px-3 py-3 text-center">
                    @lang('report.sent')
                </th>
                <th scope="col" class="px-3 py-3 text-center">
                    @lang('report.pending')
                </th>
                <th scope="col" class="px-3 py-3 text-center">
                    @lang('report.completed')
                </th>
                <th scope="col" class="px-3 py-3 text-center">
                    @lang('report.not_completed')
                </th>
                <th scope="col" class="px-3 py-3 text-center">
                    @lang('report.accepted')
                </th>
                <th scope="col" class="px-3 py-3 text-center">
                    @lang('report.ongoing_trackers')
                </th>
                <th scope="col" class="px-3 py-3 text-center">
                    @lang('report.rejected')
                </th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td v-show="!loading && directorateReportsData.length < 1" class="text-center bg-blue-100" colspan="10">
                    <div style="height: 30px;">
                        No data available
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
            <tr v-for="data in directorateReportsData" v-show="directorateReportsData.length>1 && !loading"
                class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                <td class="px-3 py-2 text-center" >
                    @{{ data.directorate }}
                </td>
                <td class="px-3 py-2 text-center">
                    @{{ data.document_type }}
                </td>
                <td class="px-3 py-2 text-center" v-if="data.docTypeSlug =='letter'">
                    @{{ data.total_trackers>0?data.letters:0 }}
                </td>
                <td class="px-3 py-2 text-center" v-if="data.docTypeSlug =='requisition'">
                    @{{ data.total_trackers>0?data.requisitions:0 }}

                </td>
                <td class="px-3 py-2 text-center" v-if="data.docTypeSlug =='suggestion'">
                    @{{ data.total_trackers>0?data.suggestions:0 }}
                </td>
                <td class="px-3 py-2 text-center">
                    @{{ data.receives }}
                </td>
                <td class="px-3 py-2 text-center">
                    @{{ data.sends }}
                </td>
                <td class="px-3 py-2 text-center">
                    @{{ data.pending }}
                </td>
                <td class="px-3 py-2 text-center">
                    @{{ data.completed }}
                </td>
                <td class="px-3 py-2 text-center">
                    @{{ data.not_completed }}
                </td>
                <td class="px-3 py-2 text-center">
                    @{{ data.approved }}
                </td>
                <td class="px-3 py-2 text-center">
                    @{{ data.ongoing }}
                </td>
                <td class="px-3 py-2 text-center">
                    @{{ data.rejected }}
                </td>
            </tr>
            </tbody>
        </table>
    </div>

</div>
