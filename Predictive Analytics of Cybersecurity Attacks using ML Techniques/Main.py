import streamlit as st
from PIL import Image

# STYLE FUNCTION SECTION

def card(text=""):
    st.markdown(f"""
    <div style='
        background-color: black;
        border-radius: 12px;
        padding: 15px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.2);
        font-family: Arial, sans-serif;
        font-size: 14px;
        height: 75px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        text-align: center;
    '>
        {text}
    </div>
    """, unsafe_allow_html=True)




# INTRO SECTION

st.set_page_config(page_title="Intrusion Detection System_main", layout="centered")

st.markdown("<center><h1 style='color:#2563eb;'>INTRUSION DETECTION SYSTEM</h1></center>", unsafe_allow_html=True)

st.write("<center><h3 style='color:#2563eb;'>A Network Monitoring Tools</h2></center>", unsafe_allow_html=True)

# Create a space
st.markdown("<br>", unsafe_allow_html=True)




# IMAGE 1 SECTION

# Load and display image
image = Image.open("image/Front-Image.jpg")
st.image(image, use_container_width=True)

# Create a space
st.markdown("<br><br>", unsafe_allow_html=True)




# OVERVIEW SECTION

# Part 1
col1, col2 = st.columns(2)

with col1:
    st.write("""
    <div style='
        text-align: left; 
        font-size: 36px; 
        font-weight:bold; 
        padding-top: 10%;
    '>
        WHAT IS INTRUSION DETECTION SYSTEM (IDS) ?
    </div>
    """, unsafe_allow_html=True)

with col2:
    st.write("""
    <div style='
        text-align: justify; 
        font-size: 16px;
        font-family: Arial, sans-serif;
        background-color: black;
        border-radius: 15px;
        padding: 10%; 
    '>
        An Intrusion Detection System (IDS) is a security tool that monitors network or system activity for malicious actions
        or policy violations. It works by analyzing traffic, logs, and system behavior to identify potential threats,
        such as unauthorized access, malware, or exploits. Once detected, the IDS generates alerts so administrators can take action.
    </div>
    """, unsafe_allow_html=True)

# Create a space
st.markdown("<br>", unsafe_allow_html=True)

# Part 2
col3, col4 = st.columns(2)

with col3:
    st.write("""
    <div style='
        text-align: justify; 
        font-size: 16px;
        font-family: Arial, sans-serif;
        background-color: black;
        border-radius: 15px;
        padding: 10%;
    '>
        It starts by collecting data on network traffic. This data is then analyzed using either signature-based detection, 
        which matches known attack patterns against a predefined database, or machine learning, which identifies deviations 
        from normal behavior. When suspicious patterns are detected such as a large number of failed login attempts, unusual 
        traffic spikes, or unauthorized access to sensitive files, the IDS generates alerts that include important details.
    </div>
    """, unsafe_allow_html=True)

with col4:
    st.write("""
    <div style='
        text-align: left; 
        font-size: 36px; 
        font-weight:bold; 
        padding-top: 10%;
        padding-left: 10%;
    '>
        HOW DOES INTRUSION DETECTION SYSTEM (IDS) WORK ?
    </div>
    """, unsafe_allow_html=True)
    
# Create a space
st.markdown("<br>", unsafe_allow_html=True)

# Part 3
st.write("""
<div style='
    text-align: left; 
    font-size: 36px;
    font-weight:bold; 
'>
    BENEFITS OF USING IDS
</div>
""", unsafe_allow_html=True)

st.write("""
<div style='
    text-align: justify; 
    font-size: 16px;
    font-family: Arial, sans-serif;
    background-color: black;
    border-radius: 15px;
    padding: 5%; 
'>
    IDS helps protect sensitive data, online services and critical infrastructure by detecting cyber threats in real time. 
    It protects individuals' personal information from being stolen, ensures businesses can operate without disruption and 
    defends public services such as hospitals, transport and utilities from cyber attacks. By identifying and alerting to 
    malicious activity early, IDS systems reduce the risk of financial loss, data breaches and system failures. 
    This contributes to a safer digital environment, increases public trust in technology and supports national security by 
    helping to prevent cybercrime and digital terrorism.
</div>
""", unsafe_allow_html=True)

# Create a space
st.markdown("<br><br><br>", unsafe_allow_html=True)




# IMAGE 2 SECTION

st.image("https://www.tripwire.com/sites/default/files/2024-03/the-importance-of-host-based-intrusion-detection-systems.jpg", use_container_width=True)
# Create a space
st.markdown("<br><br>", unsafe_allow_html=True)




# ABOUT SYSTEM SECTION

st.write("### ABOUT OUR SYSTEM")
st.write("""
<div style='
    text-align: left; 
    font-size: 16px;
    font-family: Arial, sans-serif;
    text-align: justify;
'>
    This IDS uses the XGBoost Algorithm Machine Learning to predict attacks based on the CIC-IDS2017 dataset
    created by the Canadian Institute for Cybersecurity. Several steps were taken to optimize the Machine Learning model
    including data cleaning and column filtering.
    <br><br>
    Below are <b style=color:#2563eb;>52 of the 78 attributes</b> from the CIC-IDS2017 dataset that contribute to this IDS :
    <br><br>         
</div>       
""", unsafe_allow_html=True)

# Create a card
features = [
    "Destination Port", "Flow Duration", "Total Fwd Packets", "Total Length of Fwd Packets",
    "Fwd Packet Length Max", "Fwd Packet Length Min", "Fwd Packet Length Mean", "Fwd Packet Length Std",
    "Bwd Packet Length Min", "Fwd Packet Length Min", "Bwd Packet Length Mean", "Bwd Packet Length Std",
    "Flow Bytes/s", "Flow Packets/s", "Flow IAT Mean", "Flow IAT Std",
    "Flow IAT Max", "Flow IAT Min", "Fwd IAT Total", "Fwd IAT Mean",
    "Fwd IAT Std", "Fwd IAT Max", "Fwd IAT Min", "Bwd IAT Total",
    "Bwd IAT Mean", "Bwd IAT Std", "Bwd IAT Max", "Bwd IAT Min",
    "Fwd Header Length", "Bwd Header Length", "Fwd Packets/s", "Bwd Packets/s",
    "Min Packet Length", "Max Packet Length", "Packet Length Mean", "Packet Length Std", 
    "Packet Length Variance","FIN Flag Count", "PSH Flag Count", "ACK Flag Count",
    "Average Packet Size", "Subflow Fwd Bytes", "Init_Win_bytes_forward", "Init_Win_bytes_backward", 
    "act_data_pkt_fwd", "min_seg_size_forward", "Active Mean", "Active Max", 
    "Active Min","Idle Mean", "Idle Max", "Idle Min"
]

for i in range(0, len(features), 4):
    cols = st.columns(4)
    for j in range(4):
        if i + j < len(features):
            with cols[j]:
                card(text=features[i + j])
    
    st.markdown("<div style='height: 20px;'></div>", unsafe_allow_html=True)






