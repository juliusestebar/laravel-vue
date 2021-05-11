<template>
  <v-app>
  <v-data-table
    :headers="headers"
    :items="posts"
    :footer-props="{
        'items-per-page-options': [5,10, 20, 30, 40, 50]
     }"
    :items-per-page="5"
    class="elevation-1"
  >

    <template #item.url="{ value }">
        <a :href="value">
          {{ value }}
        </a>
    </template>
    <template v-slot:item.published="{ item }">
        <v-simple-checkbox
          v-model="item.published"
          disabled
        ></v-simple-checkbox>
      </template>

    <template v-slot:top>
      <v-toolbar
        flat
      >
        <v-toolbar-title>My Article</v-toolbar-title>
        <v-divider
          class="mx-4"
          inset
          vertical
        ></v-divider>
        <v-spacer></v-spacer>
        <v-dialog
          v-model="dialog"
          max-width="500px"
        >
          <template v-slot:activator="{ on, attrs }">
            <v-btn
              color="primary"
              dark
              class="mb-2"
              v-bind="attrs"
              v-on="on"
            >
              New Article
            </v-btn>
          </template>
          <v-card>
            <v-card-title>
              <span class="headline">{{ formTitle }}</span>
            </v-card-title>

            <v-card-text>
              <v-container>
                <v-row>
                  <v-col
                    cols="12"
                    sm="12"
                    md="12"
                  >
                    <v-text-field
                      v-model="editedItem.title"
                      label="Title"
                    ></v-text-field>
                  </v-col>
                  <v-col
                    cols="12"
                    sm="12"
                    md="12"
                  >
                <v-file-input
                    v-model="editedItem.image"
                    accept="image/*"
                    label="Cover Photo"
                ></v-file-input>
                </v-col>

                  <v-col
                    cols="12"
                    sm="12"
                    md="12"
                  >
                <v-img
                max-height="150"
                max-width="250"
                :src="editedItem.cover_image"
                ></v-img>
                </v-col>
                  <v-col
                    cols="12"
                    sm="12"
                    md="12"
                  >
                    <v-textarea
                      v-model="editedItem.content"
                      label="Content"
                    ></v-textarea>
                  </v-col>
                  <v-col
                    cols="12"
                    sm="12"
                    md="12"
                  >
                    <v-text-field
                      v-model="editedItem.tags"
                      label="Tags"
                    ></v-text-field>
                  </v-col>
                  <v-col
                    cols="12"
                    sm="12"
                    md="12"
                  >

                <v-checkbox
                v-model="editedItem.published"
                :label="`Published`"
                ></v-checkbox>
                  </v-col>
                </v-row>
              </v-container>
            </v-card-text>

            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn
                color="blue darken-1"
                text
                @click="close"
              >
                Cancel
              </v-btn>
              <v-btn
                color="blue darken-1"
                text
                @click="save"
              >
                Save
              </v-btn>
            </v-card-actions>
          </v-card>
        </v-dialog>
        <v-dialog v-model="dialogDelete" max-width="500px">
          <v-card>
            <v-card-title class="headline">Are you sure you want to delete this item?</v-card-title>
            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn color="blue darken-1" text @click="closeDelete">Cancel</v-btn>
              <v-btn color="blue darken-1" text @click="deleteItemConfirm">OK</v-btn>
              <v-spacer></v-spacer>
            </v-card-actions>
          </v-card>
        </v-dialog>
      </v-toolbar>
    </template>
    <template v-slot:item.actions="{ item }">
      <v-icon
        small
        class="mr-2"
        @click="editItem(item)"
      >
        mdi-pencil
      </v-icon>
      <v-icon
        small
        @click="deleteItem(item)"
      >
        mdi-delete
      </v-icon>
    </template>
    <template v-slot:no-data>
      <v-btn
        color="primary"
        @click="initialize"
      >
        Reset
      </v-btn>
    </template>
  </v-data-table>
  </v-app>
</template>

<script>
  export default {
    data: () => ({
      dialog: false,
      dialogDelete: false,
      headers: [
        {
          text: 'Title',
          align: 'start',
          sortable: false,
          value: 'title',
        },
        { text: 'URL', value: 'url' },
        { text: 'Date Created', value: 'date_created' },
        { text: 'Date Updated', value: 'date_updated' },
        { text: 'Published', value: 'published' },
        { text: 'Actions', value: 'actions', sortable: false },
      ],
      posts: [],
      editedIndex: -1,
      editedItem: {
        id: 0,
        title: '',
        url: '',
        date_created: '',
        date_updated: '',
        tags: '',
        published: false,
        cover_image: ''
      },
      defaultItem: {
        id: 0,
        title: '',
        url: '',
        date_created: '',
        date_updated: '',
        tags: '',
        published: false,
        cover_image: ''
      },
    }),

    computed: {
      formTitle () {
        return this.editedIndex === -1 ? 'New Article' : 'Edit Article'
      },
    },

    watch: {
      dialog (val) {
        val || this.close()
      },
      dialogDelete (val) {
        val || this.closeDelete()
      },
    },

    created () {
      this.initialize()
    },

    methods: {
      initialize () {
        axios.get('/api/posts')
            .then((response) => {
                this.posts = response.data.data;
        })
            .catch(function (error) {
                console.log(error);
        });
      },

      editItem (item) {
        this.editedIndex = this.posts.indexOf(item)
        this.editedItem = Object.assign({}, item)
        this.dialog = true
      },

      deleteItem (item) {
        this.editedIndex = this.posts.indexOf(item)
        this.editedItem = Object.assign({}, item)
        this.dialogDelete = true
      },

      deleteItemConfirm () {
        axios({
            method: "delete",
            url: "api/posts/"+this.editedItem.id,
        })
        .then(function (response) {
        //handle success
            console.log(response);
        })
        .catch(function (response) {
        //handle error
            console.log(response);
        });

        this.posts.splice(this.editedIndex, 1)
        this.closeDelete()
      },

      close () {
        this.dialog = false
        this.$nextTick(() => {
          this.editedItem = Object.assign({}, this.defaultItem)
          this.editedIndex = -1
        })
      },

      closeDelete () {
        this.dialogDelete = false
        this.$nextTick(() => {
          this.editedItem = Object.assign({}, this.defaultItem)
          this.editedIndex = -1
        })
      },

      save () {
        if (this.editedIndex > -1) {

        var bodyFormData = new FormData();

        bodyFormData.append('title', this.editedItem.title);
        if(this.editedItem.image){
            bodyFormData.append("image", this.editedItem.image, this.editedItem.image.name);
        }
        bodyFormData.append('content', this.editedItem.content);
        bodyFormData.append('tags', this.editedItem.tags);
        bodyFormData.append('status', this.editedItem.published);
        bodyFormData.append('_method', "PUT");
        console.log(bodyFormData);
            axios({
                method: "post",
                url: "api/posts/"+this.editedItem.id,
                data: bodyFormData,
                headers: { "Content-Type": "multipart/form-data" },
            })
            .then(function (response) {
            //handle success
                console.log(response);
            })
            .catch(function (response) {
            //handle error
                console.log(response);
            });

          Object.assign(this.posts[this.editedIndex], this.editedItem)
        } else {


        var bodyFormData = new FormData();

        bodyFormData.append('title', this.editedItem.title);
        bodyFormData.append("image", this.editedItem.image, this.editedItem.image.name);
        bodyFormData.append('content', this.editedItem.content);
        bodyFormData.append('tags', this.editedItem.tags);
        bodyFormData.append('status', this.editedItem.published);

            axios({
                method: "post",
                url: "api/posts ",
                data: bodyFormData,
                headers: { "Content-Type": "multipart/form-data" },
            })
            .then(function (response) {
            //handle success
                console.log(response);
            })
            .catch(function (response) {
            //handle error
                console.log(response);
            });

        this.posts.push(this.editedItem)

        }

        this.close()
      },
    },
  }
</script>
