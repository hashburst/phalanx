import numpy as np
import tensorflow as tf
from tensorflow import keras
from sklearn.preprocessing import StandardScaler
from sklearn.model_selection import train_test_split
from sklearn.metrics import classification_report
import pandas as pd

class AnomalyDetectionModel:
    def __init__(self, input_shape):
        self.model = self._build_model(input_shape)
        
    def _build_model(self, input_shape):
        model = keras.Sequential([
            keras.layers.Dense(128, activation='relu', input_shape=(input_shape,)),
            keras.layers.Dropout(0.2),
            keras.layers.Dense(64, activation='relu'),
            keras.layers.Dropout(0.2),
            keras.layers.Dense(32, activation='relu'),
            keras.layers.Dense(1, activation='sigmoid')
        ])
        
        model.compile(optimizer='adam', 
                      loss='binary_crossentropy', 
                      metrics=['accuracy'])
        return model
    
    def train(self, X_train, y_train, X_val, y_val, epochs=50, batch_size=32):
        history = self.model.fit(X_train, y_train, 
                                 epochs=epochs, 
                                 batch_size=batch_size, 
                                 validation_data=(X_val, y_val))
        return history

    def predict(self, X):
        return self.model.predict(X)
    
    def evaluate(self, X_test, y_test):
        return self.model.evaluate(X_test, y_test)

# Function to preprocess data
def preprocess_data(data):
    scaler = StandardScaler()
    data_scaled = scaler.fit_transform(data)
    return data_scaled

# Function to split data into training, validation, and test sets
def split_data(X, y):
    X_train, X_temp, y_train, y_temp = train_test_split(X, y, test_size=0.4, random_state=42)
    X_val, X_test, y_val, y_test = train_test_split(X_temp, y_temp, test_size=0.5, random_state=42)
    return X_train, X_val, X_test, y_train, y_val, y_test

# Load your dataset (real data loading logic)
def load_data():
    # Replace with your actual data loading logic
    # Example: Load data from a CSV file
    df = pd.read_csv('path/to/your/data.csv')
    
    # Assuming your data has features (X) and labels (y) columns
    X = df.drop('label_column', axis=1)  # Replace 'label_column' with your actual label column name
    y = df['label_column']  # Replace 'label_column' with your actual label column name
    
    return X.values, y.values

if __name__ == "__main__":
    # Load and preprocess data
    data, labels = load_data()
    data = preprocess_data(data)
    
    # Split data
    X_train, X_val, X_test, y_train, y_val, y_test = split_data(data, labels)
    
    # Initialize and train the model
    model = AnomalyDetectionModel(input_shape=X_train.shape[1])
    model.train(X_train, y_train, X_val, y_val)
    
    # Evaluate the model
    loss, accuracy = model.evaluate(X_test, y_test)
    print(f'Test Accuracy: {accuracy*100:.2f}%')
    
    # Generate predictions
    y_pred = model.predict(X_test)
    y_pred = (y_pred > 0.5).astype(int)
    
    # Print classification report
    print(classification_report(y_test, y_pred))
