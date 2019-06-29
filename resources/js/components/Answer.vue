<template>
	<div class="media post">
        <vote :model="answer" name="answer"></vote>
        <div class="media-body">
            <form v-if="editing" @submit.prevent="updateAnswer">
                <div class="form-group">
                    <textarea class="form-control" rows="10" v-model="body" required>
                    </textarea>
                </div>
                <button class="btn btn-primary" :disabled="isInvalid">Update</button>
                <button class="btn btn-outline-secondary" @click="cancelAnswer" type="button">Cancel</button>
            </form>
            <div v-else>
                <div v-html="bodyHtml"></div>
                <div class="row">
                    <div class="col-4">
                        <div class="ml-auto">
                            <a v-if="authorize('modify', answer)" @click.prevent="editAnswer" class="btn btn-sm btn-outline-info">Edit</a>
                            <button v-if="authorize('modify', answer)" @click="destroyAnswer" class="btn btn-sm btn-outline-danger">Delete</button>
                        </div>
                    </div>
                    <div class="col-4"></div>
                    <div class="col-4">
                        <user-info :model="answer" label="Answered"></user-info>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
	props: ['answer'],

	data () {
		return {
			editing: false,
			body: this.answer.body,
			bodyHtml: this.answer.body_html,
			id: this.answer.id,
			questionId: this.answer.question_id,
			beforeEditCache: null
		}
	},

	methods: {
		editAnswer () {
			this.beforeEditCache = this.body;
			this.editing = true;
		},
		cancelAnswer () {
			this.body = this.beforeEditCache;
			this.editing = false;
		},
		updateAnswer () {
			axios.patch(this.endpoint, {
				body: this.body
			})
			.then(res => {
				this.bodyHtml = res.data.body_html;
				this.editing = false;
				this.$toast.success(res.data.message, "Success", { timeout: 3000 });
			})
			.catch(err => {
				this.$toast.error(res.response.data.message, "Error", { timeout: 3000 });
			});
		},
		destroyAnswer() {
			this.$toast.question('Are you sure about that?', 'Confirm', {
			    timeout: 20000,
			    close: false,
			    overlay: true,
			    displayMode: 'once',
			    id: 'question',
			    zindex: 999,
			    title: 'Hey',
			    position: 'center',
			    buttons: [
			        ['<button><b>YES</b></button>', (instance, toast) => {
						axios.delete(this.endpoint)
						.then(res => {
							$(this.$el).fadeOut(500, () => {
								this.$toast.success(res.data.message, "Success", { timeout: 3000 });
							})
						})
			 
			            instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
			 
			        }, true],
			        ['<button>NO</button>', function (instance, toast) {
			 
			            instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
			 
			        }],
			    ],
			});
		}
	},

	computed: {
		isInvalid () {
			return this.body.length < 10;
		},

		endpoint () {
		 	return `/questions/${this.questionId}/answers/${this.id}`
		}
	}
}
</script>