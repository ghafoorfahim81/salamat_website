<div class="">
    <section class="bg-white dark:bg-gray-900  antialiased">
        <div class="">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-lg lg:text-2xl font-bold text-gray-900 dark:text-white">{{ __('document.discussions') }}
                    (@{{ comments.length }})</h2>
            </div>
            <form>
                <div
                    class="w-full mb-4 border border-gray-200 rounded-lg bg-gray-50 dark:bg-gray-700 dark:border-gray-600">
                    <div class="px-4 py-2 bg-white rounded-t-lg dark:bg-gray-800">
                        <label for="comment" class="sr-only">Your comment</label>
                        <textarea id="comment" @input="handleInput" ref="mentionTextarea"
                                  v-model="commentForm.comment_body" rows="4"
                                  class="w-full px-0 text-sm text-gray-900 bg-white border-0 dark:bg-gray-800 focus:ring-0 dark:text-white dark:placeholder-gray-400"
                                  placeholder="{{ __('document.write_comment') }}"
                                  required></textarea>
                                                                    <textarea  :name.sync="commentForm.comment_body" @update:name="handleInput"/>
                        <div v-if="showSuggestions" class="suggestions">
                            <ul>
                                <li v-for="user in suggestedUsers" :key="user.id"
                                    @click="mentionUser(user)" class="bg-blue-100">
                                    <a href="#">@{{ user.user_name }}</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div
                        class="flex items-center justify-end px-3 py-2 border-t dark:border-gray-600">
                        <button type="button" @click="postComment"
                                class="inline-flex items-center py-2.5 px-4 text-xs font-medium text-center text-white bg-blue-700 rounded-lg focus:ring-4 focus:ring-blue-200 dark:focus:ring-blue-900 hover:bg-blue-800">
                            {{ __('document.post_comment') }}
                        </button>
                        <div class="flex ps-0 space-x-1 rtl:space-x-reverse sm:ps-1">
                            <button type="button" @click="triggerFileInput"
                                    class="inline-flex justify-center items-center p-2 text-gray-500 rounded cursor-pointer hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-600">
                                <span class="material-icons">attach_file</span>
                            </button>
                            <input type="file" id="fileInput" style="display: none;"
                                   @change="handleFileChange"/>

                            <!-- Button -->
                        </div>
                    </div>
                </div>
            </form>
            <comment-skeleton :show="loading"></comment-skeleton>
            <div>
                <comment-content :tracker-id="tracker.id"></comment-content>
            </div>

            <article class="p-2 text-base bg-white rounded-lg dark:bg-gray-900"
                     v-for="(comment,index) in comments" :key="comment.id">
                                                    <comment-content :comment="comment" :key="comment.id"
                                                                     @reply="startReply(comment.id)"
                                                                     @edit="editComment(comment)"
                                                                     @delete="deleteComment(comment.id)"></comment-content>

                <footer class="flex justify-start items-center" v-if="!comment.editing">
                    <div class="flex items-center">
                        <div
                            class="inline-flex items-center rtl:ml-0 rtl:mr-auto text-sm text-gray-900 dark:text-white font-semibold">
                            <avatar :user="comment.user.user_name"
                                    :profile-photo-path="comment.user.profile_photo_path"></avatar>
                            <div class="ml-2">@{{ comment.user.user_name }}</div>
                        </div>
                        <p class="text-sm text-gray-600 dark:text-gray-400">
                            <time>@{{ new Date(comment.created_at).toLocaleDateString() }}</time>
                        </p>
                    </div>
                    <div class="relative justify-end">
                        <button id="dropdownComment1Button"
                                @click="toggleActionButtons(comment.id,index)"
                                v-show="comment.user.id ==auth_user"
                                data-dropdown-toggle="dropdownComment1"
                                class="inline-flex items-center p-2 text-sm font-medium text-center text-gray-500 dark:text-gray-400 bg-white rounded-lg hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-50 dark:bg-gray-900 dark:hover:bg-gray-700 dark:focus:ring-gray-600"
                                type="button">
                            <span class="material-icons">more_horiz</span>
                        </button>
                        <div>
                            <comment-action-btn v-show="comment.showActionButtons"
                                                @edit="editComment(comment)"
                                                @delete="deleteComment(comment.id)"/>
                        </div>
                    </div>
                </footer>
                <p class="text-gray-500 dark:text-gray-400" v-if="!comment.editing">@{{ comment.body
                    }}</p>
                <div v-if="isImage(comment.attachment?.file)">
                    <!-- Render image -->
                    <img :src="getImagePath(comment.attachment?.file)" alt="Comment Attachment">
                </div>
                <div v-else>
                    <a :href="`{{url('/download')}}/${comment?.attachment?.id}`"
                       class="btn btn-outline-light text-blue-500">
                        @{{ comment?.attachment?.file }}
                    </a>
                </div>
                                                    <div class="flex items-center mt-4 space-x-4" v-if="!comment.editing">
                                                        <button type="button"
                                                                @click="startReply(comment.id)"
                                                                class="flex items-center text-sm text-gray-500 hover:underline dark:text-gray-400 font-medium">
                                                            <svg class="mr-1.5 w-3.5 h-3.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 18">
                                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5h5M5 8h2m6-3h2m-5 3h6m2-7H2a1 1 0 0 0-1 1v9a1 1 0 0 0 1 1h3v5l5-5h8a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1Z"/>
                                                            </svg>
                                                            Reply
                                                        </button>
                                                    </div>
                                                    edit comment

                <form>
                    <div v-if="replyingCommentId === comment.id"
                         class="w-full mb-4 border border-gray-200 rounded-lg bg-gray-50 dark:bg-gray-700 dark:border-gray-600">
                        <div class="px-4 py-2 bg-white rounded-t-lg dark:bg-gray-800">
                            <label for="comment"
                                   class="sr-only">{{ __('document.your_comment') }}</label>
                            <textarea id="comment" ref="mentionTextarea"
                                      v-model="commentReplyForm.comment_body" rows="4"
                                      class="w-full px-0 text-sm text-gray-900 bg-white border-0 dark:bg-gray-800 focus:ring-0 dark:text-white dark:placeholder-gray-400"
                                      placeholder="Write a comment..." required></textarea>
                            <div v-if="showSuggestions" class="suggestions">
                                <ul>
                                    <li v-for="user in suggestedUsers" :key="user.id"
                                        @click="mentionUser(user)" class="bg-blue-100">
                                        <a href="#">@{{ user.user_name }}</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div
                            class="flex items-center justify-between px-3 py-2 border-t dark:border-gray-600">
                            <button type="button" @click="saveReply(comment.id)"
                                    class="inline-flex items-center py-2.5 px-4 text-xs font-medium text-center text-white bg-blue-700 rounded-lg focus:ring-4 focus:ring-blue-200 dark:focus:ring-blue-900 hover:bg-blue-800">
                                {{ __('document.reply') }}
                            </button>
                                                                            <div class="flex ps-0 space-x-1 rtl:space-x-reverse sm:ps-1">
                                                                                <button type="button" class="inline-flex justify-center items-center p-2 text-gray-500 rounded cursor-pointer hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-600">
                                                                                    <span class="material-icons">attach_file</span>
                                                                                </button>
                                                                                <button type="button" class="inline-flex justify-center items-center p-2 text-gray-500 rounded cursor-pointer hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-600">
                                                                                    <span class="material-icons">image</span>
                                                                                </button>
                                                                            </div>
                        </div>
                    </div>
                </form>
                                                    edit comment

                                                    comment reply
                <form>
                    <div v-if="comment.editing"
                         class="w-full mb-4 border border-gray-200 rounded-lg bg-gray-50 dark:bg-gray-700 dark:border-gray-600">
                        <div class="px-4 py-2 bg-white rounded-t-lg dark:bg-gray-800">
                            <label for="comment"
                                   class="sr-only">{{ __('document.your_comment') }}</label>
                            <textarea id="comment" ref="mentionTextarea"
                                      v-model="commentEditForm.comment_body" rows="4"
                                      class="w-full px-0 text-sm text-gray-900 bg-white border-0 dark:bg-gray-800 focus:ring-0 dark:text-white dark:placeholder-gray-400"
                                      placeholder="{{ __('document.write_comment') }}"
                                      required></textarea>
                            <div v-if="showSuggestions" class="suggestions">
                                <ul>
                                    <li v-for="user in suggestedUsers" :key="user.id"
                                        @click="mentionUser(user)" class="bg-blue-100">
                                        <a href="#">@{{ user.user_name }}</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div
                            class="flex items-center justify-between px-3 py-2 border-t dark:border-gray-600">
                            <button type="button" @click="updateComment(comment.id)"
                                    class="inline-flex items-center py-2.5 px-4 text-xs font-medium text-center text-white bg-blue-700 rounded-lg focus:ring-4 focus:ring-blue-200 dark:focus:ring-blue-900 hover:bg-blue-800">
                                {{ __('document.update_comment') }}
                            </button>
                                                                            <div class="flex ps-0 space-x-1 rtl:space-x-reverse sm:ps-1">
                                                                                <button type="button" class="inline-flex justify-center items-center p-2 text-gray-500 rounded cursor-pointer hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-600">
                                                                                    <span class="material-icons">attach_file</span>
                                                                                </button>
                                                                                <button type="button" class="inline-flex justify-center items-center p-2 text-gray-500 rounded cursor-pointer hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-600">
                                                                                    <span class="material-icons">image</span>
                                                                                </button>
                                                                            </div>
                        </div>
                    </div>
                </form>
                                                    comment reply

            </article>
                                            <article class="p-6 mb-3 ml-6 lg:ml-12 text-base bg-white rounded-lg dark:bg-gray-900">
                                                <footer class="flex justify-between items-center mb-2">
                                                    <div class="flex items-center">
                                                        <p class="inline-flex items-center mr-3 text-sm text-gray-900 dark:text-white font-semibold"><img
                                                                class="mr-2 w-6 h-6 rounded-full"
                                                                src="https://flowbite.com/docs/images/people/profile-picture-5.jpg"
                                                                alt="Jese Leos">Jese Leos</p>
                                                        <p class="text-sm text-gray-600 dark:text-gray-400"><time pubdate datetime="2022-02-12"
                                                                                                                  title="February 12th, 2022">Feb. 12, 2022</time></p>
                                                    </div>
                                                    <button id="dropdownComment2Button" data-dropdown-toggle="dropdownComment2"
                                                            class="inline-flex items-center p-2 text-sm font-medium text-center text-gray-500 dark:text-gray-40 bg-white rounded-lg hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-50 dark:bg-gray-900 dark:hover:bg-gray-700 dark:focus:ring-gray-600"
                                                            type="button">
                                                        <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 16 3">
                                                            <path d="M2 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3Zm6.041 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM14 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3Z"/>
                                                        </svg>
                                                        <span class="sr-only">Comment settings</span>
                                                    </button>
                                                    <!-- Dropdown menu -->
                                                    <div id="dropdownComment2"
                                                         class="hidden z-10 w-36 bg-white rounded divide-y divide-gray-100 shadow dark:bg-gray-700 dark:divide-gray-600">
                                                        <ul class="py-1 text-sm text-gray-700 dark:text-gray-200"
                                                            aria-labelledby="dropdownMenuIconHorizontalButton">
                                                            <li>
                                                                <a href="#"
                                                                   class="block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Edit</a>
                                                            </li>
                                                            <li>
                                                                <a href="#"
                                                                   class="block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Remove</a>
                                                            </li>
                                                            <li>
                                                                <a href="#"
                                                                   class="block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Report</a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </footer>
                                                <p class="text-gray-500 dark:text-gray-400">Much appreciated! Glad you liked it ☺️</p>
                                                <div class="flex items-center mt-4 space-x-4">
                                                    <button type="button"
                                                            class="flex items-center text-sm text-gray-500 hover:underline dark:text-gray-400 font-medium">
                                                        <svg class="mr-1.5 w-3.5 h-3.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 18">
                                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5h5M5 8h2m6-3h2m-5 3h6m2-7H2a1 1 0 0 0-1 1v9a1 1 0 0 0 1 1h3v5l5-5h8a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1Z"/>
                                                        </svg>
                                                        Reply
                                                    </button>
                                                </div>
                                            </article>
        </div>

    </section>
</div>
