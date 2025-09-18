import streamlit as st
import pandas as pd
from model import load_model

st.set_page_config(page_title="Intrusion Detection System_fill", layout="wide")

# Title Section
st.markdown("""
    <h1 style='color:#2563eb; text-align: center;'>INTRUSION DETECTION SYSTEM</h1>
    <h3 style='text-align: center;'>Packet Details</h3>
    <p style='text-align: center;'>Please fill in the packet information below for detection analysis.</p>
""", unsafe_allow_html=True)

# Feature Fields
fields = [
    "Destination Port", "Flow Duration", "Total Fwd Packets", "Total Length of Fwd Packets",
    "Fwd Packet Length Max", "Fwd Packet Length Min", "Fwd Packet Length Mean", "Fwd Packet Length Std",
    "Bwd Packet Length Max", "Bwd Packet Length Min", "Bwd Packet Length Mean", "Bwd Packet Length Std",
    "Flow Bytes/s", "Flow Packets/s", "Flow IAT Mean", "Flow IAT Std",
    "Flow IAT Max", "Flow IAT Min", "Fwd IAT Total", "Fwd IAT Mean",
    "Fwd IAT Std", "Fwd IAT Max", "Fwd IAT Min", "Bwd IAT Total",
    "Bwd IAT Mean", "Bwd IAT Std", "Bwd IAT Max", "Bwd IAT Min",
    "Fwd Header Length", "Bwd Header Length", "Fwd Packets/s", "Bwd Packets/s",
    "Min Packet Length", "Max Packet Length", "Packet Length Mean", "Packet Length Std",
    "Packet Length Variance", "FIN Flag Count", "PSH Flag Count", "ACK Flag Count",
    "Average Packet Size", "Subflow Fwd Bytes", "Init_Win_bytes_forward",
    "Init_Win_bytes_backward", "act_data_pkt_fwd", "min_seg_size_forward",
    "Active Mean", "Active Max", "Active Min", "Idle Mean", "Idle Max", "Idle Min"
]

field_keys = [field.replace(" ", "_") for field in fields]

# Initialize Session State
for key in field_keys:
    if key not in st.session_state:
        st.session_state[key] = 0.0

# Reset Handler
if "clear_all" not in st.session_state:
    st.session_state.clear_all = False

if st.session_state.clear_all:
    for key in field_keys:
        st.session_state[key] = 0.0
    st.session_state.clear_all = False
    st.rerun()

# Input Handler
def number_input_with_validation(label):
    key = label.replace(" ", "_")
    return st.number_input(label, key=key, format="%.6f", step=0.01)

# === FORM ===
with st.form("packet_form"):
    values = {}
    chunk_size = len(fields) // 4 + (len(fields) % 4 > 0)
    cols = st.columns(4)

    for i in range(chunk_size):
        for j in range(4):
            idx = i + j * chunk_size
            if idx < len(fields):
                with cols[j]:
                    values[fields[idx]] = number_input_with_validation(fields[idx])

    st.markdown("<div style='height: 10px;'></div>", unsafe_allow_html=True)

    # Buttons Centered and Side-by-Side
    col_spacer1, col_center, col_spacer2 = st.columns([1.5, 2, 1.5])

    with col_center:
        col_btn1, col_btn2 = st.columns(2)

        with col_btn1:
            submitted = st.form_submit_button("✅ Check Packet", use_container_width=True)

        with col_btn2:
            cleared = st.form_submit_button("🧹 Clear All", use_container_width=True)
            if cleared:
                st.session_state.clear_all = True

    # === Prediction Result ===
    if submitted:
        try:
            values = {k: float(v) for k, v in values.items()}
            model, column_order, label_encoder, scaler = load_model()

            input_df = pd.DataFrame([values])
            input_df = input_df[column_order]

            scaled_input = scaler.transform(input_df)
            prediction_code = model.predict(scaled_input)[0]
            prediction_label = label_encoder.inverse_transform([prediction_code])[0]

            # Output Color logic
            if prediction_label == "Normal Traffic":
                bg_color = "#002900"  # dark green
                text_color = "#22c55e"  # light green
            else:
                bg_color = "#290000"  # dark red
                text_color = "#ff4d4d"  # bright red



            # OUTPUT
            st.markdown(f"""
            <div style='padding-bottom:15px;'>
                <div style='text-align:center; font-size:18px; padding:15px; background-color:{bg_color}; border-radius:10px;'>
                    <b>Prediction:</b> <span style='color:{text_color}; font-weight:bold;'>{prediction_label}</span>
                </div>
            </div>
            """, unsafe_allow_html=True)

        except ValueError:
            st.error("🚫 Please ensure all fields are filled with valid numeric values.")
        except Exception as e:
            st.error(f"🚫 Error: {e}")
