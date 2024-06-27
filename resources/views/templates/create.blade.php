@extends('adminlte::page')

@section('title', 'Create Email Template')

@section('content_header')
    <h1>Create Email Template</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.templates.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="name">Template Name:</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>
                <div class="form-group">
                    <label for="content">Template Content:</label>
                    <textarea class="form-control" id="content" name="content" rows="10"></textarea>
                </div>
                <div class="form-group">
                    <button type="button" class="btn btn-primary mr-2" data-toggle="modal" data-target="#placeholderModal">
                        Add Placeholder
                    </button>
                    <div class="btn-group">
                        <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Insert Placeholder
                        </button>
                        <div class="dropdown-menu" id="placeholdersDropdown">
                            @foreach($placeholders as $placeholder)
                                <a class="dropdown-item" href="#" data-placeholder="{{ $placeholder->name }}">{{ $placeholder->name }}</a>
                            @endforeach
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Save Template</button>
            </form>
        </div>
    </div>

    <!-- Placeholder Modal -->
    <div class="modal fade" id="placeholderModal" tabindex="-1" role="dialog" aria-labelledby="placeholderModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="placeholderModalLabel">Add Custom Placeholder</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="customPlaceholder">Enter Placeholder Name:</label>
                        <input type="text" class="form-control" id="customPlaceholder" placeholder="e.g., [Placeholder]" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="insertCustomPlaceholderBtn">Insert Placeholder</button>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    {{-- Add here extra stylesheets --}}
    <style>
        .cke_placeholder {
            background-color: #f0f0f0;
            border: 1px dashed #ccc;
            color: #666;
        }
    </style>
@stop

@section('js')
    {{-- CKEditor script --}}
    <script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
    <script>
        // Register a placeholder widget
        CKEDITOR.plugins.add('placeholder', {
            requires: 'widget',
            init: function(editor) {
                editor.widgets.add('placeholder', {
                    inline: true,
                    editable: false,
                    template: '<span class="cke_widget_element cke_placeholder" contenteditable="false">[Placeholder]</span>',
                    allowedContent: 'span(!cke_widget_element,cke_placeholder)',
                    upcast: function(element) {
                        return element.name == 'span' && element.hasClass('cke_placeholder');
                    }
                });
            }
        });

        // Initialize CKEditor
        CKEDITOR.replace('content', {
            extraPlugins: 'widget,placeholder',
            allowedContent: true,
            on: {
                instanceReady: function(evt) {
                    var editor = evt.editor;

                    // Handle placeholder insertion from dropdown
                    document.querySelectorAll('.dropdown-item').forEach(item => {
                        item.addEventListener('click', function(event) {
                            event.preventDefault();
                            var placeholder = this.getAttribute('data-placeholder');
                            editor.widgets.initOn(editor.insertHtml('<span class="cke_widget_element cke_placeholder">' + placeholder + '</span>'), 'placeholder');
                        });
                    });

                    // Handle custom placeholder insertion from modal
                    document.getElementById('insertCustomPlaceholderBtn').addEventListener('click', function() {
                        var placeholder = document.getElementById('customPlaceholder').value;
                        if (placeholder) {
                            fetch('{{ route('admin.placeholders.add') }}', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                },
                                body: JSON.stringify({ name: placeholder })
                            })
                            .then(response => response.json())
                            .then(data => {
                                editor.widgets.initOn(editor.insertHtml('<span class="cke_widget_element cke_placeholder">' + data.name + '</span>'), 'placeholder');
                                $('#placeholderModal').modal('hide');
                                // Add new placeholder to the dropdown
                                var newPlaceholderItem = document.createElement('a');
                                newPlaceholderItem.className = 'dropdown-item';
                                newPlaceholderItem.href = '#';
                                newPlaceholderItem.setAttribute('data-placeholder', data.name);
                                newPlaceholderItem.textContent = data.name;
                                document.getElementById('placeholdersDropdown').appendChild(newPlaceholderItem);

                                // Re-bind event to new item
                                newPlaceholderItem.addEventListener('click', function(event) {
                                    event.preventDefault();
                                    var placeholder = this.getAttribute('data-placeholder');
                                    editor.widgets.initOn(editor.insertHtml('<span class="cke_widget_element cke_placeholder">' + placeholder + '</span>'), 'placeholder');
                                });
                            });
                        }
                    });

                    // Handle backspace to delete only the placeholder
                    editor.on('key', function(evt) {
                        if (evt.data.keyCode === 8) { // 8 is the keycode for backspace
                            var selection = editor.getSelection();
                            var range = selection.getRanges()[0];
                            var startContainer = range.startContainer;

                            if (startContainer.$.nodeType === Node.ELEMENT_NODE && startContainer.$.classList.contains('cke_placeholder')) {
                                range.setStartBefore(startContainer);
                                range.setEndAfter(startContainer);
                                range.deleteContents();
                                evt.cancel();
                            } else if (startContainer.$.nodeType === Node.TEXT_NODE && startContainer.getParent().hasClass('cke_placeholder')) {
                                var parentElement = startContainer.getParent();
                                range.setStartBefore(parentElement);
                                range.setEndAfter(parentElement);
                                range.deleteContents();
                                evt.cancel();
                            }
                        }
                    });
                }
            }
        });
    </script>
@stop
