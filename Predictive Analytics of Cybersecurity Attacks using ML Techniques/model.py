# Calling the Model

import joblib

def load_model():
    model, column_order, label_encoder, scaler = joblib.load("ids_xgb_model.pkl")
    return model, column_order, label_encoder, scaler
