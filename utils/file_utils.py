import os
import json

def read_file(path):
    if os.path.exists(path):
        with open(path, 'r') as f:
            return f.read()
    return None

def write_file(path, data):
    with open(path, 'w') as f:
        f.write(data)

def append_file(path, data):
    with open(path, 'a') as f:
        f.write(data)

def delete_file(path):
    if os.path.exists(path):
        os.remove(path)

def list_files(dir_path):
    if os.path.exists(dir_path) and os.path.isdir(dir_path):
        return os.listdir(dir_path)
    return []

def read_json(path):
    content = read_file(path)
    if content:
        return json.loads(content)
    return None

def write_json(path, data):
    write_file(path, json.dumps(data))

def create_dir(path):
    if not os.path.exists(path):
        os.makedirs(path)

def delete_dir(path):
    if os.path.exists(path) and os.path.isdir(path):
        os.rmdir(path)
