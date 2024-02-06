 <template>
    <div>
        <!-- Your existing comment display logic here -->

        <!-- Add a section for real-time updates -->
        <div v-if="realTimeComment">
            New Comment: {{ realTimeComment }}
        </div>
    </div>
</template>

<script>
export default {
    props: ['trackerId', 'comment'],
    data() {
        return {
            realTimeComment: null,
        };
    },
    mounted() {
        console.log('this is from a new comment')
        // Listen for real-time events
        window.Echo.channel('tracker.' + this.trackerId)
            .listen('CommentAdded', (event) => {
                // Handle the new comment event
                console.log('New comment added!')
                this.realTimeComment = event.comment;

                // Clear the realTimeComment after 5 seconds (adjust as needed)
                // setTimeout(() => {
                //     this.realTimeComment = null;
                // }, 3000);
            });
    },
};
</script>

