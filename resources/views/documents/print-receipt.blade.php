

<!DOCTYPE html>
<html dir="rtl">
<head>
<title>
 </title>
<style>
        @font-face {
            font-family: persian;
            src: url('{{ asset('fonts/FontsFree-Net-ir_sans.ttf') }}');
        }

        * {
             font-family: persian;
         }

    </style>
<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/vue@2.6.14/dist/vue.min.js"></script>
</head>
<body>


<div class="max-w-xl mx-auto bg-white p-8 shadow-md rounded-lg">
    <div class="flex justify-between mb-4">
        <div>
            <img src="{{url('assets/images/emarat_logo.jpeg')}}" alt="Logo 2" class="h-12 mr-4">
            <span>امارت اسلامی افغانستان</span>
        </div>
        <div class="text-center">
            <p>{{$level3->name_prs??''}}</p>
            <p>{{$level2->name_prs}}</p>
            <p>{{$level1->name_prs}}</p>
        </div>
        <div class="text-center">
            <img src="{{url('assets/images/mof_logo.jpeg')}}" alt="Logo 1" class="h-12 mr-4">
            <span>وزارت مالیه</span>
        </div>
    </div>
    <hr class="my-4">
{{--            <div class="flex justify-start">--}}
{{--                <p class="font-bold">{{ __('document.title') }}:</p>--}}
{{--                <p class="mx-4">{{ $tracker->title }}</p>--}}
{{--            </div>--}}
    <div class="section-to-print" id="printableArea">
        <div class="flex justify-between mb-2">
            <div class="flex justify-start">
                <p class="font-bold">{{ __('document.issue_date') }}:</p>
                <p class="mx-1">{{ ($tracker->created_at) }}</p>
            </div>
            <div class="flex justify-end">
                <p class="font-bold">{{ __('document.deadline') }}:</p>
                <p class="mx-1">{{ ($tracker->deadline_days) }} {{__('document.day')}}</p>
            </div>
        </div>
        <div class="flex justify-between mb-2">
            <div class="flex justify-end">
                <p class="font-bold">{{ __('general_words.number') }}:</p>
                <p class="mx-1">{{ ($tracker->out_num) }}</p>
            </div>
        </div>
        <hr>
        <div class="flex justify-between mt-2">
            <div class="flex justify-start">
                <p class="font-bold">{{ __('document.document_type') }}:</p>
                <p class="mx-1">{{ $tracker->doc_type_name }}</p>
            </div>

        </div>
        <div class="flex justify-between mb-2">
            <div class="flex justify-start">
                <p class="font-bold">{{ __('general_words.directorate') }}:</p>
                <p class="mx-1">{{ $tracker->sender }} </p>
            </div>
        </div>
        <div class="flex justify-between mb-2">
            <div class="flex justify-start">
                <p class="font-bold">{{ __('general_words.name') }}:</p>
                <p class="mx-1">{{ $tracker->focal_point_name }}</p>
            </div>
        </div>
        <div class="flex justify-between mb-2">
            <div class="flex justify-start">
                <p class="font-bold">{{ __('general_words.phone_number') }}:</p>
                <p class="mx-1">{{ $tracker->phone_number }}</p>
            </div>
        </div>
        <div class="flex justify-between mb-2">
            <div class="flex justify-start">
                <p class="font-bold">{{ __('document.sender') }}:</p>
                <p class="mx-1">{{ $tracker->senderEmp }} </p>
            </div>
        </div>
        <div class="flex justify-between mb-2">
            <div class="flex justify-start">
                <p class="font-bold">{{ __('document.receiver') }}:</p>
                <p class="mx-1">{{ $tracker->receiver }}</p>
            </div>
        </div>
        <div class="flex justify-between mb-2">
            <div class="flex justify-end">
                <p class="font-bold">{{ __('document.total_attachments') }}:</p>
                <p class="mx-1">{{ $tracker->attachment_count }}</p>
            </div>
        </div>
        <div class="flex justify-between mb-2">
            <div class="flex justify-start">
                <p class="font-bold">{{ __('document.user') }}:</p>
                <p class="mx-1">{{ $tracker->user }}</p>
            </div>
        </div>
        <div class="flex justify-between mb-2">
            <div class="flex justify-start">
                <p class="font-bold">{{ __('document.remark') }}:</p>
                <p class="mx-1">{{ $tracker->remark }}</p>
            </div>
        </div>
        {!! QrCode::encoding('UTF-8')->color(255, 0, 0)->generate('documents/show/'.$tracker->document_id) !!}
    </div>
    <!-- <button @click="printDiv('printableArea')" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
        Print
    </button> -->
</div>

</body>
</html>
<script>
new Vue({
	el: '#app',
	mounted() {
		// this.printPage();
	},
	methods: {
		printPage() {
			window.print();
		},

	}
});
</script>
