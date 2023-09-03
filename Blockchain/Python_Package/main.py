from flask import Flask, jsonify, request
from keyGenerate import generatePrivateKeyPublicAddress
from util import bytes_needed, decode_base58, little_endian_to_int, int_to_little_endian
import json
import sys


app = Flask(__name__)


@app.route('/generate_keys', methods=['GET'])
def generate_keys():
    result = generatePrivateKeyPublicAddress()
    return result


# ======================================================================================================================

@app.route('/get_bytes_needed', methods=['POST'])
def get_bytes_needed():
    data = request.get_json()
    if 'value' not in data:
        return jsonify({'error': 'Missing values'}), 400
    val = int(data['value'])
    result = bytes_needed(val)
    return jsonify({"result": result}), 201


# ======================================================================================================================

@app.route('/get_decode_base58', methods=['POST'])
def get_decode_base58():
    data = request.get_json()
    if 'value' not in data:
        return jsonify({'error': 'Missing values'}), 400
    byte_data = decode_base58(data['value'])
    hex_data = byte_data.hex()
    response = {
        'byte_data': hex_data
    }
    return jsonify(response)


if __name__ == '__main__':
    app.run(debug=True)
