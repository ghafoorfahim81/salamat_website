<template>
    <!--begin datatable  -->
    <div class="row">
        <div class="flex items-center justify-between pb-4">
            <div>
                <div class="relative px-2" @click="showDropdown">
                    <button
                        class="text-black z-10 bg-gray-100 hover:bg-gray-200 focus:ring-2 focus:outline-none focus:ring-blue-100 font-xs rounded-md text-small px-3 py-2.5 text-center inline-flex items-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                        type="button">
                        {{ perPageText }}
                        <svg class="w-2.5 h-2.5 ml-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                             fill="none" viewBox="0 0 10 6">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="m1 1 4 4 4-4"/>
                        </svg>
                    </button>
                    <div v-if="isDropdownVisible"
                         class="absolute top-full right-0 mt-2 bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-200 z-10">
                        <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownHoverButton">
                            <li v-for="item in appPerPage" :key="item">
                                <a href="#"
                                   class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white"
                                   @click="perPageChange(item)">
                                    {{ item }}
                                </a>
                            </li>

                        </ul>
                    </div>
                </div>

            </div>
            <label for="table-search" class="sr-only">Search</label>
            <div class="relative p-2">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" aria-hidden="true" fill="currentColor"
                         viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                              d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                              clip-rule="evenodd"></path>
                    </svg>
                </div>
                <input type="text" v-model="filter" @input="getData"
                       class="block p-2 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                       :placeholder="search">
            </div>
        </div>

        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <slot name="thead">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr class="dark:bg-gray-800 dark:border-gray-700">
                        <th v-for="(col,index) in columns" :key="index"
                            @click="sort(index)"
                            scope="col" class="px-4 py-2 bg-sky-600 text-white"
                            :style="{cursor:(col.sort===true)?'pointer':'','white-space':(col.sort===true)?'nowrap':'wrap'}">
                            <template v-if="col.sort===true">

                                <i class="fa fa-arrow-down"
                                   :style="{color:(getColumnSortClass(index).direction==='asc' && activeSortColumn===col.name)?'#DC4322':'#c2c2a3'}"
                                   style="margin-right:-1.5px;margin-left:-1.5px;"></i>
                                <i class="fa fa-arrow-up"
                                   :style="{color:(getColumnSortClass(index).direction==='desc' && activeSortColumn===col.name)?'#DC4322':'#c2c2a3'}"
                                   style="margin-right:-1.5px;margin-left:-1.5px;"></i>
                            </template>

                            {{ col.label }}
                        </th>
                    </tr>
                    </thead>
                    <template v-if="data.total !=undefined">
                        <template id="no_record_found_text" v-if="data.total<1">
                            <tbody>
                            <tr>
                                <td :colspan="columns.length">
                                    {{ noRecordFoundText }}
                                </td>
                            </tr>
                            </tbody>
                        </template>
                    </template>
                </slot>
                <slot name="tbody">
                    <tbody>
                    <tr>
                        <td>asdf</td>
                    </tr>
                    </tbody>
                </slot>
            </table>

        </div>

        <!--end  datatable  -->
        <div class="col-md-12">
            <div class="col-md-12">
                <table style="border-spacing: 10px;border-collapse: separate;" class="bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr class="flex justify-center mr-10">
                        <td>
                            <renderless-laravel-vue-pagination :data="data" :limit="limit"
                                                               :show-disabled="showDisabled" :size="size"
                                                               :align="align"
                                                               v-on:pagination-change-page="onPaginationChangePage">
                                <ul class="inline-flex -space-x-px text-sm" :class="{
                                    'pagination-sm': size == 'small',
                                    'pagination-lg': size == 'large',
                                    'justify-content-center': align == 'center',
                                    'justify-content-end': align == 'right'
                                }" v-if="computed.total > computed.perPage"
                                    slot-scope="{ data, limit, showDisabled, size, align, computed, prevButtonEvents, nextButtonEvents, pageButtonEvents }">

                                    <li :class="{'disabled': !computed.prevPageUrl}"
                                        v-if="computed.prevPageUrl || showDisabled">
                                        <a class="flex items-center justify-center px-3 h-8 ml-0 leading-tight text-gray-500 bg-white border border-gray-300
                                        rounded-l-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400
                                         dark:hover:bg-gray-700 dark:hover:text-white" href="#" aria-label="Previous"
                                           :tabindex="!computed.prevPageUrl && -1" v-on="prevButtonEvents">
                                            <slot>
                                                <span>{{ previous }} &nbsp</span>
                                            </slot>
                                        </a>
                                    </li>

                                    <li class="page-item pagination-page-nav"
                                        v-for="(page, key) in computed.pageRange" :key="key"
                                        :class="{ 'active': page == computed.currentPage }">
                                        <a class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100
                            hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white"
                                           href="#" v-on="pageButtonEvents(page)">
                                            {{ page }}
                                            <span class="sr-only"
                                                  v-if="page == computed.currentPage">({{ current }} &nbsp)</span>
                                        </a>
                                    </li>

                                    <li
                                        :class="{'disabled': !computed.nextPageUrl}"
                                        v-if="computed.nextPageUrl || showDisabled">
                                        <a class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300
                            rounded-r-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400
                            dark:hover:bg-gray-700 dark:hover:text-white" href="#" aria-label="Next"
                                           :tabindex="!computed.nextPageUrl && -1" v-on="nextButtonEvents">
                                            <slot name="next-nav">
                                                <span>{{ next }} &nbsp</span>
                                            </slot>
                                        </a>
                                    </li>

                                </ul>
                            </renderless-laravel-vue-pagination>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</template>

<script>

import RenderlessLaravelVuePagination from '../pagination/RenderlessLaravelVuePagination.vue';

export default {
    props: {
        noRecordFoundText: {
            type: String,
            default: '',
        },
        search: {
            type: String,
            default: '',
        },
        searchPlaceholderText: {
            type: String,
            default: '',
        },
        current: {
            type: String,
            default: 'current',
        },
        next: {
            type: String,
            default: 'next',
        },
        previous: {
            type: String,
            default: 'previous',
        },
        perPageText: {
            type: String,
            default: 'Item per page',
        },
        showingText: {
            type: String,
            default: '',
        },
        fromText: {
            type: String,
            default: 'From',
        },
        toText: {
            type: String,
            default: 'To',
        },
        recordText: {
            type: String,
            default: 'Record',
        },
        perPage: {
            type: Number,
            default: 1
        },
        appPerPage: {
            type: Array,
            default: () => [5, 10, 20, 50, 100, 500]
        },
        columns: {
            type: Array,
            default: () => []
        },
        data: {
            type: Object,
            default: () => {
            }
        },
        limit: {
            type: Number,
            default: 0
        },
        showDisabled: {
            type: Boolean,
            default: false
        },
        size: {
            type: String,
            default: 'default',
            validator: value => {
                return ['small', 'default', 'large'].indexOf(value) !== -1;
            }
        },
        align: {
            type: String,
            default: 'left',
            validator: value => {
                return ['left', 'center', 'right'].indexOf(value) !== -1;
            }
        },
        multipleSelect: {
            type: Boolean,
            default: false
        },
        selectedRows: {
            type: Array,
            default: () => []
        },


    },
    data() {
        return {
            filter: '',
            activeSortColumn: '',
            activeSortDirection: '',
            // dataPerPage: 10,
            userDataPerPage: 10,
            isDropdownVisible: false,
            current_page: 1,
            selectAll:false,
        }
    },
    computed: {

        totalRecord() {
            let total=0;
            if(this.selectedRows)
            {
                total=this.selectedRows.length;
            }
            if(total==0)
            {
                this.selectAll=false;
            }
            return total;

        },
        dataPerPage(){
            return this.userDataPerPage
        }
    },
    mounted() {
        this.userDataPerPage = this.perPage;
        for (var i = 0; i < this.columns.length; i++) {
            if (this.columns[i].sort === true && this.columns[i].activeSort != undefined) {
                if (this.columns[i].activeSort === true) {
                    this.activeSortColumn = this.columns[i].name;
                    this.activeSortDirection = this.columns[i].order_direction;
                    break;
                }
            }

        }
        this.setUrl();

    },

    methods: {
        //
        showDropdown() {
            this.isDropdownVisible = !this.isDropdownVisible;
        },
        hideDropdown() {
            this.isDropdownVisible = false;
        },
        deleteSelectedRecord()
        {
            this.selectAll=!this.selectAll;
            this.$emit('delete-method-action',null);

            // this.$parent.deleteMethodName(3434);
        },
        toggleSelectAll(event) {
            this.selectAll=!this.selectAll;
            this.$parent.selectedRows//


            if(this.selectAll)
            {
                if(this.data && this.data.data)
                {
                    for (let i = 0; i <this.data.data.length ; i++)
                    {
                        this.$parent.selectedRows.push(this.data.data[i].id)
                    }

                }

            }
            else
            {
                this.$parent.selectedRows=[];
            }


        },
        getData() {
            this.setUrl();
        },
        perPageChange() {
            this.setUrl();
        },
        onPaginationChangePage(page) {
            this.current_page = page;
            this.$emit('pagination-change-page', page);
        },
        onSortChange(page) {
            this.$emit('sort-change', page, activeSortDirection);
        },
        //return colum sort direction default is ascending
        getColumnSortClass(index) {
            let dir = '';
            if (this.columns[index] != undefined) {

                if (this.columns[index].sort != undefined && this.columns[index].sort === true) {
                    dir = 'asc';
                    if (this.columns[index].order_direction != undefined) {
                        dir = this.columns[index].order_direction.toLowerCase();

                    }

                    if (this.columns[index].name === this.activeSortColumn) {
                        if (dir === 'desc') {

                        } else if (dir === 'asc') {

                        } else {

                        }
                    }
                }
            }
            return {direction: dir};
        },
        // sort columns
        sort(index, reload = true) {
            let color = '#7a7a52';
            let dir = '';
            if (this.columns[index] != undefined && this.columns[index].sort === true) {

                color = '#99c2ff';
                if (this.columns[index].name === this.activeSortColumn) {
                    dir = this.activeSortDirection === 'asc' ? 'desc' : 'asc';
                } else {
                    this.activeSortColumn = this.columns[index].name;
                    dir = 'asc';
                    if (this.columns[index].order_direction != undefined) {
                        dir = this.columns[index].order_direction.toLowerCase();
                    }
                }
                this.activeSortDirection = dir;
                this.columns[index].order_direction = dir;

                if (reload === true) {
                    this.setUrl();
                }
            } else {
                this.activeSortColumn = '';
                this.activeSortDirection = '';
            }

            return {color: color, direction: dir};

        },

        setUrl(sendRequest = true) {
            let url = this.$parent.url;
            this.$parent.perPage = this.userDataPerPage;
            if (this.activeSortColumn != '' && this.activeSortColumn != undefined &&
                this.activeSortDirection != undefined && this.activeSortDirection != '') {
                if (url.search('&order_direction') === -1) {

                    let tempUrl = this.$parent.url + 'order_by=' + this.activeSortColumn + '&order_direction=' + this.activeSortDirection;

                    if (this.dataPerPage > 0) {
                        tempUrl = this.$parent.url + 'order_by=' + this.activeSortColumn + '&per_page=' + this.dataPerPage + '&order_direction=' + this.activeSortDirection;
                        ;

                    }
                    tempUrl = tempUrl + "&search_keyword=" + this.filter;
                    this.$parent.url = tempUrl;
                } else {
                    let order_direction = '&order_direction';
                    let toLenght = url.search('&order_direction');
                    let newUrlPortion = url.slice(0, Number(toLenght) + Number(order_direction.length));
                    let sortCheck = url.slice(Number(newUrlPortion.length) + 1);
                    let temp = url.slice(0, url.search('order_by'));
                    let newUrl = 'order_by=' + this.activeSortColumn + '&order_direction=' + this.activeSortDirection;
                    if (this.dataPerPage > 0) {
                        newUrl = 'order_by=' + this.activeSortColumn + '&per_page=' + this.dataPerPage + '&order_direction=' + this.activeSortDirection;
                    }
                    newUrl = newUrl + "&search_keyword=" + this.filter;
                    this.$parent.url = temp + newUrl;
                }
            }
            if (sendRequest) {
                this.$emit('pagination-change-page', this.page);
            }
        }
    },

    components: {
        RenderlessLaravelVuePagination
    }
}
</script>
<style>
.form-floating>.form-control::placeholder {
    color: #000!important
}
</style>


