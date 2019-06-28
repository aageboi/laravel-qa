<answer :answer="{{ $answer }}" inline-template>
    <div class="media post">
        @include ('shared._vote', [
            'model' => $answer
        ])
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
                            @can('update', $answer)
                            <!-- <a href="{{ route('questions.answers.edit', [$question->id, $answer->id]) }}" class="btn btn-sm btn-outline-info">Edit</a> -->
                            <a @click.prevent="editAnswer" class="btn btn-sm btn-outline-info">Edit</a>
                            @endcan
                            @can('delete', $answer)
                            <form class="form-delete" method="post" action="{{ route('questions.answers.destroy', [$question->id, $answer->id]) }}">
                                @method('DELETE')
                                @csrf
                                <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                            @endcan
                        </div>
                    </div>
                    <div class="col-4"></div>
                    <div class="col-4">
                        <!-- @include ('shared._author', [
                            'model' => $answer,
                            'label' => 'answered'
                        ]) -->
                        <user-info :model='{{ $answer }}' label="Answered"></user-info>
                    </div>
                </div>
            </div>
        </div>
    </div>
</answer>