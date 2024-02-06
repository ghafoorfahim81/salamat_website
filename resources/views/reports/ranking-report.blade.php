
<div class="flex flex-wrap">
    <!-- Removed w-full to allow this div to only be as wide as its content -->
    <div class="relative flex justify-start w-1/3">
        <v-select :options="statuses" class="text-sm text-width w-full" label="name"
                  @input="getRankingData"
                  v-model="selected_order_status"></v-select>
        <floating-label :id="'deputy'" :label="`{{__('document.document_status')}}`"/>
    </div>
    <!-- This div should now be on the same line as the first div if there is space -->
    <div class="relative flex justify-end flex-grow">
        <excel-btn :label="`{{__('general_words.download')}}`" :loading="ranking_download_loading" @download="exportRankingReport"/>
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
                    @lang('report.directorate')
                </th>
                <th scope="col" class="px-3 py-3 text-center">
                    @lang('report.total_trackers')
                </th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td v-show="!loading && rankingReportData.length < 1" class="text-center bg-blue-100" colspan="10">
                    <div style="height: 30px;">
                        No data available
                    </div>
                </td>
            </tr>
            <template v-for="show in 4" v-show="loading">
                <tr>
                    <td v-for="showTd in 2">
                        <skeleton :show="loading"/>
                    </td>
                </tr>
            </template>
            <tr v-for="data in rankingReportData" v-show="rankingReportData.length>0 && !loading"
                class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                <td class="px-3 py-2 text-center" v-if=>
                    @{{ data.directorate }}
                </td>
                <td class="px-3 py-2 text-center">
                    @{{ selected_order_status.slug === 'completed' ? data.completed :
                    (selected_order_status.slug === 'approved' ? data.approved :
                    (selected_order_status.slug === 'pending' ? data.pending :
                    (selected_order_status.slug === 'ongoing' ? data.ongoing :
                    (selected_order_status.slug === 'rejected' ? data.rejected :
                    (selected_order_status.slug === 'not_completed' ? data.not_completed : 0)))))}}
                </td>
            </tr>
            </tbody>
        </table>
    </div>

</div>
