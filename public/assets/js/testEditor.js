class TestEditor {
  btn = {
    $addQuestion: null,
  };

  constructor () {
    this.init.elements();
    this.init.listeners();
    this.init.vars();
  }

  init = {
    elements : () => {
      this.$root = $(`#test-editor`);
      if (!this.$root.length) {
        throw new Error('Root not found');
      }

      this.form.$form = $(`#testEditorForm`);
      if (!this.form.$form.length) {
        throw new Error('Form not found');
      }
      this.form.$form.on('submit', () => false);
      this.form.$input = this.form.$form.find(`input[name='name']`);
      if (!this.form.$input.length) {
        throw new Error('Form input not found');
      }
      this.$questions = this.$root.find('ul.questions');
      if (!this.$questions.length) {
        throw new Error('Questions ul not found');
      }
      this.$tabs = this.$root.find(`div.tab-content`);
      if (!this.$tabs.length) {
        throw new Error('Tabs not found');
      }
      this.btn.$addQuestion = $(`#add-question-btn`);
      if (!this.btn.$addQuestion.length) {
        throw new Error('Add question button not found');
      }
    },
    vars     : () => {
      this.url = this.generateBaseUrl();
      this.variantId = this.form.$form.find(`input[name="variant"]`).val();
      this.apiUrl = this.url + `/api/variant/${this.variantId}/`;
    },
    listeners: () => {
      this.btn.$addQuestion.click(async () => {
        this.api.question.add();
      });

      this.form.$form.find(`.close`).click(() => {
        this.form.hide();
      });
      const self = this;
      $(document).on('click', 'button.edit-question-title', function () {
        const $this = $(this);
        const questionId = $this.closest(`[data-question-id]`)
                                .first()
                                .attr(`data-question-id`),
              title      = $this.parent().find(`span`).text();
        self.form.$input.val(title);
        self.form.show($this);
        self.form.$form.on('submit', () => {
          self.api.question.editTitle(questionId, self.form.$input.val());
        });
      });
    },
  };
  api = {
    request : async (url, data = [], method = 'GET') => {
      const settings = {
        method,
        headers: {
          'Content-Type': 'application/json;charset=utf-8',
        },
      };
      if (method.toLowerCase() === 'post') {
        settings.body = JSON.stringify(data);
      } else if (method.toLowerCase() === 'get') {
        url = new URL(url);
        for (let key in data) {
          url.searchParams.append(key, data[key]);
        }
      }

      const response = await fetch(url);

      if (response.ok) {
        const text = await response.text();
        let json;
        try {
          json = JSON.parse(text);
        } catch (e) {
          return text;
        }
        if (json.error) {
          throw json.error_msg;
        } else {
          return json.data;
        }

      } else {
        throw new Error(
          `Request error ` + (response.statusText || response.status));
      }
    },
    question: {
      add      : () => {
        let url = this.apiUrl + `question/add`;
        let questionId;
        this.api.request(url)
            .then(data => {
              return data.id;
            })
            .catch(e => {throw e;})
            .then(async id => {
              questionId = id;
              url = this.url +
                `/admin/variant/${this.variantId}/question/${questionId}`;
              return await this.api.request(url);
            })
            .then(data => {
              const $data     = $(data),
                    $question = $data.find(
                      `ul.questions li[data-question-id=${questionId}]`),
                    $tab      = $data.find(
                      `.tab[data-question-id=${questionId}]`);
              this.$questions.find(`li`).removeClass(`active`);
              this.$tabs.find(`.tab`).removeClass(`active`);
              $question.appendTo(this.$questions);
              $tab.appendTo(this.$tabs);

            })
            .catch(e => {throw e;});

      },
      editTitle: (questionId, title) => {
        let url = this.apiUrl + `question/${questionId}/edit/title`;
        const $elems = $(`li[data-question-id="${questionId}"] > a, div.tab[data-question-id="${questionId}"] .question-title span`);
        if ($elems.first().text() !== title) {
          this.api.request(url, { title })
              .then(data => {
                $elems.text(title);
              })
              .catch(e => {throw e;});
        }
        this.form.hide();
      },
    },

  };
  form = {
    show: ($object) => {
      const pos = $object.offset();
      pos.top = pos.top + 10;
      pos.left = pos.left + 10;
      this.form.$form.removeClass('hidden').offset(pos);
    },
    hide: () => {
      this.form.$form.addClass('hidden');
      this.form.$form.off('submit');
      this.form.$form.on('submit', () => false);
    },
  };

  generateBaseUrl = () => {
    let baseUrl = window.location.protocol + '//' + window.location.hostname;
    if (window.location.port) baseUrl += ':' + window.location.port;
    return baseUrl;
  };
};