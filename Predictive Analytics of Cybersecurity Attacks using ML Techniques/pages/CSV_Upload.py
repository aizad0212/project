import streamlit as st
import pandas as pd
import numpy as np
import matplotlib.pyplot as plt
import textwrap
from model import load_model

st.set_page_config(page_title="Intrusion Detection System_upload", layout="centered")

st.markdown("<h1 style='color:#2563eb;'>INTRUSION DETECTION SYSTEM</h1>", unsafe_allow_html=True)
st.write("### Packet Details")
st.write("Please upload a CSV file & Ensure it has mandatory columns.")

uploaded_file = st.file_uploader("Choose a CSV file:", type="csv")

if uploaded_file is not None:
    df = pd.read_csv(uploaded_file)
    st.success("✅ File successfully uploaded.")
    
    st.write("### Preview of Uploaded Data:")
    st.dataframe(df.head())

    # 1 - Clean column names
    df.columns = df.columns.str.strip()

    # 2 - Remove duplicate rows
    original_len = len(df)
    df.drop_duplicates(inplace=True)
    removed_dupes = original_len - len(df)
    if removed_dupes > 0:
        st.info(f"🧹 Removed {removed_dupes} duplicate rows.")

    # 3 - Replace inf/-inf with NaN, then fill NaN with 0 (Handle missing values)
    df.replace([np.inf, -np.inf], np.nan, inplace=True)
    if df.isnull().sum().sum() > 0:
        df.fillna(0, inplace=True)
        st.warning("⚠️ Missing or infinite values found. All filled with 0.")

    # 4 - Select Columns
    selected_columns = [
        "Destination Port", "Flow Duration", "Total Fwd Packets", "Total Length of Fwd Packets",
        "Fwd Packet Length Max", "Fwd Packet Length Min", "Fwd Packet Length Mean", "Fwd Packet Length Std",
        "Bwd Packet Length Max", "Bwd Packet Length Min", "Bwd Packet Length Mean", "Bwd Packet Length Std",
        "Flow Bytes/s", "Flow Packets/s", "Flow IAT Mean", "Flow IAT Std", "Flow IAT Max", "Flow IAT Min",
        "Fwd IAT Total", "Fwd IAT Mean", "Fwd IAT Std", "Fwd IAT Max", "Fwd IAT Min",
        "Bwd IAT Total", "Bwd IAT Mean", "Bwd IAT Std", "Bwd IAT Max", "Bwd IAT Min",
        "Fwd Header Length", "Bwd Header Length", "Fwd Packets/s", "Bwd Packets/s",
        "Min Packet Length", "Max Packet Length", "Packet Length Mean", "Packet Length Std", "Packet Length Variance",
        "FIN Flag Count", "PSH Flag Count", "ACK Flag Count",
        "Average Packet Size", "Subflow Fwd Bytes", 
        "Init_Win_bytes_forward", "Init_Win_bytes_backward", 
        "act_data_pkt_fwd", "min_seg_size_forward",
        "Active Mean", "Active Max", "Active Min",
        "Idle Mean", "Idle Max", "Idle Min"
    ]

    existing_columns = [col for col in selected_columns if col in df.columns]
    missing_columns = [col for col in selected_columns if col not in df.columns]

    if missing_columns:
        st.error(f"❌ Missing expected features:\n{missing_columns}")
        st.stop()

    # Keep only selected columns
    df = df[existing_columns].copy()

    # Prediction Button
    if st.button("🔍 Check Packet", use_container_width=True):
        try:
            model, column_order, label_encoder, scaler = load_model()

            # Confirm all model-required columns are present
            missing_model_cols = [col for col in column_order if col not in df.columns]
            if missing_model_cols:
                st.error(f"❌ Missing model-required columns:\n{missing_model_cols}")
                st.stop()

            # Filter and reorder for model
            df_predict = df[column_order].copy()

            # Scale
            input_data = scaler.transform(df_predict)

            # Predict
            y_pred = model.predict(input_data)
            y_label = label_encoder.inverse_transform(y_pred)

            # Create full result with predictions
            df['Predicted Code'] = y_pred
            df['Predicted Attack Type'] = y_label

            
            
            
            # OUTPUT

            # 📊 Graph Prediction Distribution by Attack Type

            # Define the attack types and their order
            attack_order = ["Normal Traffic", "DoS", "DDoS", "Port Scanning", "Brute Force", "Web Attacks", "Bots"]
            attack_counts = df['Predicted Attack Type'].value_counts().reindex(attack_order, fill_value=0)

            # Color
            colors = ['#1f77b4' if attack == 'Normal Traffic' else '#e74c3c' for attack in attack_order]

            # Wrap labels (insert line break if too long)
            wrapped_labels = ['\n'.join(textwrap.wrap(label, width=10)) for label in attack_order]

            # Create figure with color background
            fig, ax = plt.subplots(figsize=(10, 5), facecolor='black')
            ax.set_facecolor('black')

            # Bar chart
            bars = ax.bar(attack_order, attack_counts.values, color=colors)

            # Add count labels ABOVE bar
            for i, bar in enumerate(bars):
                height = bar.get_height()
                ax.text(bar.get_x() + bar.get_width()/2, height * 1.05, str(int(height)),
                        ha='center', va='bottom', color='white', fontweight='bold', fontsize=10)

            # Add wrapped category labels INSIDE graph BELOW each bar
            for i, bar in enumerate(bars):
                ax.text(bar.get_x() + bar.get_width()/2, -0.1, wrapped_labels[i],
                        ha='center', va='top', color='white', fontweight='bold', fontsize=10)

            # Clean up axes
            ax.set_xlim(-0.5, len(attack_order) - 0.5)
            ax.set_ylim(0, max(attack_counts.values) * 1.2)
            ax.set_xticks([])  # Remove default x-tick labels
            ax.set_yticks([])
            ax.spines['top'].set_visible(False)
            ax.spines['right'].set_visible(False)
            ax.spines['left'].set_visible(False)
            ax.spines['bottom'].set_visible(False)

            # No axis labels
            ax.set_xlabel("")
            ax.set_ylabel("")
            ax.set_title("")

            st.pyplot(fig)


            # Show table display
            st.markdown("### 🧠 Predictions:")
            st.dataframe(df[['Destination Port', 'Predicted Attack Type']])


            # Download result as CSV
            csv_data = df.to_csv(index=False).encode('utf-8')
            st.download_button(
                label="📥 Download Prediction",
                data=csv_data,
                file_name='IDS_predictions.csv',
                mime='text/csv'
            )

        except Exception as e:
            st.error(f"❌ Error during prediction: {e}")
