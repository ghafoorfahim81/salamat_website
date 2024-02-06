<section class="bg-white dark:bg-gray-900 py-8 lg:py-16 antialiased">
    <div class="w-full">
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

        <article class="p-6 text-base bg-white rounded-lg dark:bg-gray-900" v-for="(comment,index) in comments"
                 :key="comment.id">
            <footer class="flex justify-between items-center" v-if="!comment.editing">
                <div class="flex items-center">
                    <p class="inline-flex items-center mr-3 rtl:mr-auto rtl:ml-3 text-sm text-gray-900 dark:text-white font-semibold">
                        <img
                            class="mr-2 rtl:mr-auto rtl:ml-2 w-6 h-6 rounded-full"
                            src="https://flowbite.com/docs/images/people/profile-picture-2.jpg"
                            alt="Michael Gough">@{{ comment.user.user_name }}</p>
                    <p class="text-sm text-gray-600 dark:text-gray-400">
                        <time pubdate datetime="2022-02-08"
                        >@{{new Date(comment.created_at).toLocaleDateString()}}
                        </time>
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
                                            :edit-label="`{{ __('general_words.edit') }}`"
                                            :delete-label="'{{ __('general_words.delete') }}'"
                                            @delete="deleteComment(comment.id)"/>
                    </div>
                </div>
            </footer>
            <p class="text-gray-500 dark:text-gray-400" v-if="!comment.editing">
                @{{ comment.body}}
            </p>
            <div v-if="isImage(comment.attachment?.file)">
                <img :src="getImagePath(comment.attachment?.file)" alt="Comment Attachment">
            </div>
            <div v-else>
                <a :href="`{{url('/download')}}/${comment?.attachment?.id}`"
                   class="btn btn-outline-light text-blue-500">
                    @{{ comment?.attachment?.file }}
                </a>
            </div>
            <div class="flex items-center space-x-4" v-if="!comment.editing">
                <button type="button"
                        @click="startReply(comment.id)"
                        class="flex items-center text-sm text-gray-500 hover:underline dark:text-gray-400 font-medium">
                    <i class="material-icons mr-1.5 w-3.5 h-3.5 mb-2">reply</i>
                    {{ __('document.reply_to_comment') }}
                </button>
            </div>
            {{--            reply to comment--}}
            <form>
                <div v-if="replyingCommentId === comment.id"
                     class="w-full mb-4 border border-gray-200 rounded-lg bg-gray-50 dark:bg-gray-700 dark:border-gray-600">
                    <div class="px-4 py-2 bg-white rounded-t-lg dark:bg-gray-800">
                        <label for="comment"
                               class="sr-only">{{ __('document.your_comment') }}</label>
                        <textarea id="comment" ref="mentionTextarea"
                                  v-model="commentReplyForm.comment_body" rows="4"
                                  class="w-full px-0 text-sm text-gray-900 bg-white border-0 dark:bg-gray-800 focus:ring-0 dark:text-white dark:placeholder-gray-400"
                                  placeholder="{{ __('document.write_reply') }}" required></textarea>

                    </div>
                    <div
                        class="flex items-center justify-between px-3 py-2 border-t dark:border-gray-600">
                        <div class="flex">
                            <button type="button" @click="saveReply(comment.id)"
                                    class="inline-flex items-center py-2.5 ml-1 px-4 text-xs font-medium text-center text-white bg-blue-700 rounded-lg focus:ring-4 focus:ring-blue-200 dark:focus:ring-blue-900 hover:bg-blue-800">
                                {{ __('document.reply') }}
                            </button>
                            <button type="button" @click="replyingCommentId=null"
                                    class="inline-flex items-center py-2.5 px-4
                                     text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 font-medium rounded-md text-sm p  dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700">
                                {{ __('general_words.cancel') }}
                            </button>
                        </div>
                        <div class="flex ps-0 space-x-1 rtl:space-x-reverse sm:ps-1">
                            <button type="button" @click="triggerReplyFileInput"
                                    class="inline-flex justify-center items-center p-2 text-gray-500 rounded cursor-pointer hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-600">
                                <span class="material-icons">attach_file</span>
                            </button>
                            <input type="file" id="replyFileInput" style="display: none;"
                                   @change="handleReplyFileChange"/>
                        </div>
                    </div>
                </div>
            </form>
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

                    </div>
                    <div
                        class="flex items-center justify-between px-3 py-2 border-t dark:border-gray-600">
                        <div class="flex">
                            <button type="button" @click="updateComment(comment.id)"
                                    class="inline-flex items-center py-2.5 ml-1 px-4 text-xs font-medium text-center text-white bg-blue-700 rounded-lg focus:ring-4 focus:ring-blue-200 dark:focus:ring-blue-900 hover:bg-blue-800">
                                {{ __('document.update_comment') }}
                            </button>
                            <button type="button" @click="comment.editing=false"
                                    class="inline-flex items-center py-2.5 px-4
                                     text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 font-medium rounded-md text-sm p  dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700">
                                {{ __('general_words.cancel') }}
                            </button>
                        </div>

                        <div class="flex ps-0 space-x-1 rtl:space-x-reverse sm:ps-1">
                            <button type="button" @click="triggerEditFileInput"
                                    class="inline-flex justify-center items-center p-2 text-gray-500 rounded cursor-pointer hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-600">
                                <span class="material-icons">attach_file</span>
                            </button>
                            <input type="file" id="editFileInput" style="display: none;"
                                   @change="handleEditFileChange"/>
                        </div>
                    </div>
                </div>
            </form>
            <article
                class="p-6 mb-3 ml-6 lg:ml-12 rtl:lg:mr-12 rtl:lg:ml-auto text-base bg-white rounded-lg dark:bg-gray-900" v-for="reply in comment.replies">
                <footer class="flex justify-between items-center mb-2" v-show="!reply.editing">
                    <div class="flex items-center">
                        <p class="inline-flex items-center rtl:mr-auto rtl:ml-2  mr-3 text-sm text-gray-900 dark:text-white font-semibold"><img
                                class="mr-2 w-6 h-6 rtl:mr-auto rtl:ml-2 rounded-full"
                                src="https://flowbite.com/docs/images/people/profile-picture-5.jpg"
                                alt="Jese Leos">@{{ reply.user.user_name }}</p>
                        <p class="text-sm text-gray-600 dark:text-gray-400">
                            <time pubdate datetime="2022-02-12"
                                  title="February 12th, 2022">@{{ new Date(reply.created_at).toLocaleDateString() }}
                            </time>
                        </p>
                    </div>
                    <div class="relative justify-end">
                        <button id="dropdownComment1Button"
                                @click="toggleReplyActionButtons(comment.id,reply.id)"
                                v-show="reply.user.id ==auth_user"
                                data-dropdown-toggle="dropdownComment1"
                                class="inline-flex items-center p-2 text-sm font-medium text-center text-gray-500 dark:text-gray-400 bg-white rounded-lg hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-50 dark:bg-gray-900 dark:hover:bg-gray-700 dark:focus:ring-gray-600"
                                type="button">
                            <span class="material-icons">more_horiz</span>
                        </button>
                        <div>
                            <comment-action-btn v-show="reply.showActionButtons"
                                                @edit="editReply(comment.id,reply.id)"
                                                :edit-label="`{{ __('general_words.edit') }}`"
                                                :delete-label="'{{ __('general_words.delete') }}'"
                                                @delete="deleteReply(comment.id,reply.id)"/>
                        </div>
                    </div>
                </footer>
                <p class="text-gray-500 dark:text-gray-400" v-show="!reply.editing">@{{ reply.body }}️</p>
                <div v-if="isImage(reply.attachment?.file)" v-show="!reply.editing">
                    <img :src="getImagePath(reply.attachment?.file)" alt="Comment Attachment">
                </div>
                <div v-else v-show="!reply.editing">
                    <a :href="`{{url('/download')}}/${reply?.attachment?.id}`"
                       class="btn btn-outline-light text-blue-500">
                        @{{ reply?.attachment?.file }}
                    </a>
                </div>
                <form>
                    <div v-if="reply.editing"
                         class="w-full mb-4 border border-gray-200 rounded-lg bg-gray-50 dark:bg-gray-700 dark:border-gray-600">
                        <div class="px-4 py-2 bg-white rounded-t-lg dark:bg-gray-800">
                            <label for="comment"
                                   class="sr-only">{{ __('document.your_comment') }}</label>
                            <textarea id="comment" ref="mentionTextarea"
                                      v-model="replyEditForm.comment_body" rows="4"
                                      class="w-full px-0 text-sm text-gray-900 bg-white border-0 dark:bg-gray-800 focus:ring-0 dark:text-white dark:placeholder-gray-400"
                                      placeholder="{{ __('document.write_comment') }}"
                                      required></textarea>

                        </div>
                        <div
                            class="flex items-center justify-between px-3 py-2 border-t dark:border-gray-600">
                            <div class="flex">
                                <button type="button" @click="updateReply(reply.id,comment.id)"
                                        class="inline-flex items-center py-2.5 ml-1 px-4 text-xs font-medium text-center text-white bg-blue-700 rounded-lg focus:ring-4 focus:ring-blue-200 dark:focus:ring-blue-900 hover:bg-blue-800">
                                    {{ __('document.update_reply') }}
                                </button>
                                <button type="button" @click="reply.editing=false"
                                        class="inline-flex items-center py-2.5 px-4
                                     text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 font-medium rounded-md text-sm p  dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700">
                                    {{ __('general_words.cancel') }}
                                </button>
                            </div>

                            <div class="flex ps-0 space-x-1 rtl:space-x-reverse sm:ps-1">
                                <button type="button" @click="triggerEditReplyFileInput"
                                        class="inline-flex justify-center items-center p-2 text-gray-500 rounded cursor-pointer hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-600">
                                    <span class="material-icons">attach_file</span>
                                </button>
                                <input type="file" id="replyEditFileInput" style="display: none;"
                                       @change="handleEditReplyFileChange"/>
                            </div>
                        </div>
                    </div>
                </form>
            </article>
        </article>

    </div>
</section>
